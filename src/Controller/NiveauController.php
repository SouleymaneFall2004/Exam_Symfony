<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Entity\Cours;
use App\Repository\NiveauRepository;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NiveauController extends AbstractController
{
    #[Route('/niveaux', name: 'niveaux_list')]
    public function list(NiveauRepository $repository): Response
    {
        $niveaux = $repository->findAll();

        return $this->render('niveau/list.html.twig', [
            'niveaux' => $niveaux,
        ]);
    }

    #[Route('/niveaux/ajouter', name: 'add_niveau')]
    public function addNiveau(Request $request, EntityManagerInterface $entityManager, CoursRepository $coursRepository): Response
    {
        $niveau = new Niveau();
        $form = $this->createFormBuilder($niveau)
            ->add('nomNiveau', TextType::class, [
                'label' => 'Nom du Niveau',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'nomCours',
                'placeholder' => 'Aucun',
                'required' => false,
                'attr' => ['class' => 'form-select'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer',
                'attr' => ['class' => 'bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveau);
            $entityManager->flush();

            return $this->redirectToRoute('niveaux_list');
        }

        return $this->render('niveaux/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}