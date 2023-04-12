<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EchangeController extends AbstractController
{
    #[Route('/echange', name: 'app_echange')]
    public function index(): Response
    {
        return $this->render('echange/index.html.twig', [
            'controller_name' => 'EchangeController',
        ]);
    }
}
