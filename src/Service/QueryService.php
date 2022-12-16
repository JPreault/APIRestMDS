<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository; 

class QueryService 
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function findProduct(string $productId): Product | array
    {
        $productByID = $this->productRepository->find($productId);
        $productByCode = $this->productRepository->findBy(['code' => $productId]);
        if($productByID === null && count($productByCode) === 0){
            $product = null;
        }else if ($productByID === null){
            $product = $productByCode[0];
        }else if (count($productByCode) === 0){
            $product = $productByID;
        }
        if($product === null){
            $message = 'Error encountered : No product with the id or the code -> '.$productId;
            $product = ['id' => $message, 'code'=> $message,'stock' => 0,'name' => $message];
        }else{
            if($product->getName() === ''){
                $productFromApiOFF = json_decode(file_get_contents('https://world.openfoodfacts.org/api/v2/search?code='.$product->getCode().'&fields=product_name'),true);
                $product->setName($productFromApiOFF['products'][0]['product_name']);
            }
        }
        return $product;
    }

    public function getAllProducts(): array 
    {
        /*$codeIsExistInOFF = file_get_contents('https://world.openfoodfacts.org/api/v2/search?code='.$productDetails['code']);
            if($codeIsExistInOFF['count'] = 0){
                $message = 'Error encountered : This code isn\'t assigned to a reel product';
                $product = ['id' => $message, 'code'=> $message,'stock' => 0,'name' => $message];
            } else {
                $product = new Product();
                $product->setName($productDetails['name']);
                $product->setStock($productDetails['stock']);
                $product->setCode($productDetails['code']);

                $this->manager->persist($product);
                $this->manager->flush();
            }*/
        return $this->productRepository->findAll();
    }
}
