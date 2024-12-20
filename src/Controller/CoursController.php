<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Niveau;
use App\Entity\Professeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    #[Route('/cours/by-classe/{id}', name: 'cours_by_classe')]
    public function getCoursByClasse(int $id, EntityManagerInterface $entityManager): Response
    {
        $classe = $entityManager->getRepository(Classe::class)->find($id);

        if (!$classe) {
            throw $this->createNotFoundException('Classe non trouvée.');
        }

        $cours = $classe->getCours();

        return $this->render('cours/list.html.twig', [
            'classe' => $classe,
            'cours' => $cours,
        ]);
    }

    #[Route('/cours/by-niveau/{id}', name: 'cours_by_niveau')]
    public function getCoursByNiveau(int $id, EntityManagerInterface $entityManager): Response
    {
        $niveau = $entityManager->getRepository(Niveau::class)->find($id);

        if (!$niveau) {
            throw $this->createNotFoundException('Niveau non trouvé.');
        }

        $cours = $niveau->getCours() ? [$niveau->getCours()] : [];

        return $this->render('cours/list.html.twig', [
            'niveau' => $niveau,
            'cours' => $cours,
        ]);
    }

    #[Route('/cours/by-professeur/{id}', name: 'cours_by_professeur')]
    public function getCoursByProfesseur(int $id, EntityManagerInterface $entityManager): Response
    {
        $professeur = $entityManager->getRepository(Professeur::class)->find($id);

        if (!$professeur) {
            throw $this->createNotFoundException('Professeur non trouvé.');
        }

        $cours = $professeur->getCours() ? [$professeur->getCours()] : [];

        return $this->render('cours/list.html.twig', [
            'professeur' => $professeur,
            'cours' => $cours,
        ]);
    }
}