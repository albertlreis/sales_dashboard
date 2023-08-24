<?php

namespace App\Controller;

use App\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SaleController extends AbstractController
{
    /**
     * @Route("/sale", name="app_sale_index")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $sales = $entityManager->getRepository(Sale::class)->findAll();

        return $this->render('sale/index.html.twig', [
            'sales' => $sales,
        ]);
    }
}
