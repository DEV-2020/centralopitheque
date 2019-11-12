<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="shop", methods={"GET"})
     */
    public function index(ShopRepository $shopRepository): JsonResponse
    {
        return $this->json(
            $shopRepository->findAll(),
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['default', 'withOwner']]
        );
    }

    /**
     * @Route("/shops/{id}", name="shop_detail", methods={"GET"})   
     */
    public function detail(Shop $shop): JsonResponse
    {
        return $this->json(
            $shop,
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['default', 'withOwner']]
        );
    }
}
