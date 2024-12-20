<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

class ProfesseurController extends AbstractController
{
    #[Route('/professeurs', name: 'professeurs_list')]
    public function list(ProfesseurRepository $repository): Response
    {
        $professeurs = $repository->findAll();

        return $this->render('professeur/list.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }
}