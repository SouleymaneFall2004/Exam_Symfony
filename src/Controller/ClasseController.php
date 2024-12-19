<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Cours;
use App\Repository\CoursRepository;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClasseController extends AbstractController
{
    #[Route('/classes', name: 'classes_list')]
    public function list(ClasseRepository $repository): Response
    {
        $classes = $repository->findAll();

        return $this->render('classe/list.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/classes/ajouter', name: 'add_classe')]
    public function addClasse(Request $request, EntityManagerInterface $entityManager, CoursRepository $coursRepository): Response
    {
        $classe = new Classe();
        $form = $this->createFormBuilder($classe)
            ->add('nomClasse', TextType::class, [
                'label' => 'Nom de la Classe',
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
            $entityManager->persist($classe);
            $entityManager->flush();

            return $this->redirectToRoute('list_classes');
        }

        return $this->render('classes/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
