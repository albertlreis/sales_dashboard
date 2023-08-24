<?php
namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="app_client_index")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $clients = $entityManager->getRepository(Client::class)->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
}
