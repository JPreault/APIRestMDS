<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraints\Length;

class MutationService 
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ProductRepository $productRepository,
    ) {}

    public function createProduct(array $productDetails): Product | array
    {   
        $sameNameProduct = $this->productRepository->findBy(['name' => $productDetails['name']]);
        $sameCodeProduct = $this->productRepository->findBy(['code' => $productDetails['code']]);
        if(count($sameNameProduct) > 0){
            $message = 'Error encountered : This name is already used for this id product -> '.$sameNameProduct[0]->getId();
            $product = ['id' => $message, 'code'=> $message,'stock' => 0,'name' => $message];
        }else if (count($sameCodeProduct) > 0) {
            $message = 'Error encountered : This code is already used for this id product -> '.$sameCodeProduct[0]->getId();
            $product = ['id' => $message, 'code'=> $message,'stock' => 0,'name' => $message];
        }else{
            if(strlen($productDetails['code']) !== 13) {
                $message = 'Error encountered : This code havn\'t the right length (13 numbers)';
                $product = ['id' => $message, 'code'=> $message,'stock' => 0,'name' => $message];
            }else {
                $product = new Product();
                $product->setName($productDetails['name']);
                $product->setStock($productDetails['stock']);
                $product->setCode($productDetails['code']);

                $this->manager->persist($product);
                $this->manager->flush();
            }
        }

        return $product;
    }
}
