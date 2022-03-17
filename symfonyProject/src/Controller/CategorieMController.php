<?php

namespace App\Controller;

use App\Entity\CategorieM;
use App\Form\CategorieMType;
use App\Repository\CategorieMRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/m")
 */
class CategorieMController extends AbstractController
{
    /**
     * @Route("/", name="categorie_m_index", methods={"GET"})
     */
    public function index(CategorieMRepository $categorieMRepository): Response
    {

        return $this->render('categorie_m/index.html.twig', [
            'categorie_ms' => $categorieMRepository->findAll(),


        ]);
    }

    /**
     * @Route("/new", name="categorie_m_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieM = new CategorieM();
        $form = $this->createForm(CategorieMType::class, $categorieM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieM);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_m_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_m/new.html.twig', [
            'categorie_m' => $categorieM,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_m_show", methods={"GET"})
     */
    public function show(CategorieM $categorieM): Response
    {
        return $this->render('categorie_m/show.html.twig', [
            'categorie_m' => $categorieM,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_m_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategorieM $categorieM, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieMType::class, $categorieM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categorie_m_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_m/edit.html.twig', [
            'categorie_m' => $categorieM,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_m_delete", methods={"POST"})
     */
    public function delete(Request $request, CategorieM $categorieM, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieM->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieM);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_m_index', [], Response::HTTP_SEE_OTHER);
    }
}
