<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleType;
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

    /**
     * @Route("/sale/create", name="app_sale_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Calculate the total price of the sale based on the products
            $total = 0;
            foreach ($sale->getSaleItems() as $saleItem) {
                $total += $saleItem->getProduct()->getPrice() * $saleItem->getQuantity();
                $saleItem->setTotalAmount($saleItem->getProduct()->getPrice() * $saleItem->getQuantity());
                $entityManager->persist($saleItem);
            }
            $sale->setTotalAmount($total);

            $entityManager->persist($sale);
            $entityManager->flush();

            $this->addFlash('success', 'Sale created successfully.');

            return $this->redirectToRoute('app_sale_index');
        }

        return $this->render('sale/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
