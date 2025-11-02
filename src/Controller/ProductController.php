<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;

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
}
