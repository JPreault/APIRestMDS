<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class MutationService 
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}

    public function createProduct(array $productDetails): Product 
    {
        $product = new Product();

        $product->setName($productDetails['name']);
        $product->setStock($productDetails['stock']);
        $product->setCode($productDetails['code']);

        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }
}
