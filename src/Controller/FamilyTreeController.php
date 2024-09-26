<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FamilyTreeController extends AbstractController
{
    #[Route('/family_tree', name: 'app_family_tree')]
    public function index(): Response
    {
        return $this->render('family_tree/index.html.twig', [
            'controller_name' => 'FamilyTreeController',
        ]);
    }
}
