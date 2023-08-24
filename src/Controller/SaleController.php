<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Form\SaleItemType;
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

    /**
     * @Route("/sale/{id}/edit", name="app_sale_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $sale = $entityManager->getRepository(Sale::class)->find($id);

        if (!$sale) {
            throw $this->createNotFoundException('Venda não encontrada');
        }

        $form = $this->createForm(SaleType::class, $sale);

        $saleItemsForm = $this->createForm(SaleItemType::class, null, [
            'sale' => $sale,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Atualize os dados da venda e seus produtos aqui
            // ...

            $entityManager->flush();

            $this->addFlash('success', 'Sale updated successfully.');

            return $this->redirectToRoute('app_sale_index');
        }

        return $this->render('sale/edit.html.twig', [
            'form' => $form->createView(),
            'sale' => $sale,
            'saleItemsForm' => $saleItemsForm->createView(),
        ]);
    }
}
