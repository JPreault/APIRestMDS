<?php

namespace App\Controller;

use Exception;
use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'Aucun produit n\'a été trouvé'
            );
        }
        return $this->json($products);
    }

    #[Route('/create', name: 'create_product', methods: ['POST'])]
    public function createProduct(ValidatorInterface $validator, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setStock($request->get('stock'));

        
        if(count($validator->validate($product)) > 0) {
            return $this->json('Error with your params !');
        };

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json($product);
    }

    #[Route('/read', name: 'read_product', methods: ['GET'])]
    public function readProduct(ManagerRegistry $doctrine, Request $request): Response
    {
        $id =$request->get('id');

        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product) {
            return $this->json('id not found in database');
        }

        return $this->json($product);
    }

    #[Route('/update', name: 'update_product', methods: ['POST'])]
    public function updateProduct(ValidatorInterface $validator, ManagerRegistry $doctrine, Request $request): Response
    {
        $id = $request->get('id');
        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product) {
            return $this->json('id not found in database');
        }

        try {
            $product->setName($request->get('name'));
            $product->setStock($request->get('stock'));
            if(count($validator->validate($product)) > 0){
                return $this->json('Error appeared, go read the documentation !');
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        } catch (\Throwable $e) {
            var_dump($e);
            return $this->json('Error appeared, go read the documentation !');
        }

        return $this->json($product);
    }

    #[Route('/delete', name: 'relete_product', methods: ['DELETE'])]
    public function deleteProduct(ManagerRegistry $doctrine, Request $request): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($request->get('id'));

        if(!$product) {
            return $this->json('id not found in database');
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->json(true);
    }

    #[Route('/addStock', name: 'add_product', methods: ['POST'])]
    public function addStock(ValidatorInterface $validator, ManagerRegistry $doctrine, Request $request): Response
    {
        $id = $request->get('id');
        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product) {
            return $this->json('id not found in database');
        }

        try {
            $product->setStock($product->getStock() + $request->get('stock'));
            if(count($validator->validate($product)) > 0){
                return $this->json('Error appeared, go read the documentation !');
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        } catch (\Throwable $e) {
            var_dump($e);
            return $this->json('Error appeared, go read the documentation !');
        }

        return $this->json($product);
    }

    #[Route('/removeStock', name: 'remove_product', methods: ['POST'])]
    public function removeStock(ValidatorInterface $validator, ManagerRegistry $doctrine, Request $request): Response
    {
        $id = $request->get('id');
        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product) {
            return $this->json('id not found in database');
        }

        try {
            $product->setStock($product->getStock() - $request->get('stock'));
            if(count($validator->validate($product)) > 0){
                return $this->json('Error appeared, go read the documentation !');
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        } catch (\Throwable $e) {
            var_dump($e);
            return $this->json('Error appeared, go read the documentation !');
        }

        return $this->json($product);
    }

    /*#[Route('/', name: 'app_product')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $products = $doctrine->getRepository(Product::class)->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'Aucun produit n\'a été trouvé'
            );
        }

        return $this->renderForm('product/index.html.twig', [
            'productList' => $products,
        ]);
    }

    #[Route('/{id}/update', name: 'update_product', methods: ['GET', 'POST'])]
    public function updateProduct(ManagerRegistry $doctrine, Request $request, Product $product): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();
            
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            return 'Tout c\'est bien passé chacal !';
            return new Response('Tout c\'est bien passé chacal !');
        }

        return $this->renderForm('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'delete_product', methods: ['GET', 'POST'])]
    public function deleteProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setStock(3);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }*/
}
