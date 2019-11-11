<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="shop")
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
}
