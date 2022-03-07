<?php

namespace App\Controller;

use App\Entity\CategorieE;
use App\Entity\Evenement;
use App\Form\CategorieEType;
use App\Repository\CategorieERepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/categorie/e")
 */
class CategorieEController extends AbstractController
{
    /**
     * @Route("/", name="categorie_e_index", methods={"GET"})
     */
    public function index(CategorieERepository $categorieERepository): Response
    {
        return $this->render('categorie_e/index.html.twig', [
            'categories' => $categorieERepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_e_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieE = new CategorieE();
        $form = $this->createForm(CategorieEType::class, $categorieE)
            ->add('image_e',FileType::class,[
                'mapped'=>false,
                'required'=>true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Only images',
                    ])
                ],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image_e')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $categorieE->setImageE($newFilename);
            }
            $entityManager->persist($categorieE);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_e_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_e/new.html.twig', [
            'categorie_e' => $categorieE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_e_show", methods={"GET"})
     */
    public function show(CategorieE $categorieE): Response
    {
        return $this->render('categorie_e/show.html.twig', [
            'categorie_e' => $categorieE,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_e_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategorieE $categorieE, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieEType::class, $categorieE)
            ->add('image_e',FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Only images',
                    ])
                ],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image_e')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $categorieE->setImageE($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('categorie_e_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_e/edit.html.twig', [
            'categorie_e' => $categorieE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_e_delete", methods={"POST"})
     */
    public function delete(Request $request, CategorieE $categorieE, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieE->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_e_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/catEvent/{id}", name="events_cat")
     */
    public function getCatEvents($id, CategorieERepository $repo)
    {
        $events = $repo->getEvents($id);
        return $this->render('categorie_e/events.html.twig',[
            'events'=>$events
        ]);
    }
}
