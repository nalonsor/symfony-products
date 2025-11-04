<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        // dump($products); // dump to inspect the products
        // dd($products); // dump and die to inspect the products

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'product_show')] // Added route requirement for id to be digits only
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Product created successfully!');
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }
        // Logic for creating a new product would go here
        return $this->render('product/new.html.twig', [
            //'form' => $form->createView(),
            'form' => $form,
        ]);
    }

    #[Route('/product/{id<\d+>}/edit', name: 'product_edit')]
    public function edit($id, ProductRepository $productRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Product updated successfully!');
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Request $request, Product $product, EntityManagerInterface $manager): Response
    {
        if($request->isMethod('POST')) {
            $manager->remove($product);
            $manager->flush();
            $this->addFlash('success', 'Product deleted successfully!');
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/delete.html.twig', [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'size' => $product->getSize(),
        ]);
    }
}
