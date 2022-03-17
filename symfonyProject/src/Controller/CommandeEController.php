<?php

namespace App\Controller;

use App\Entity\CommandeE;
use App\Entity\Evenement;
use App\Form\CommandeEType;
use App\Repository\CommandeERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/commandee")
 */
class CommandeEController extends AbstractController
{
    /**
     * @Route("/list_commandee", name="commande_e_index", methods={"GET"})
     */
    public function index(CommandeERepository $commandeERepository): Response
    {$list_commandee = $commandeERepository->findAll();
        return $this->render('commande_e/index.html.twig', [
            'commande_es' => $list_commandee,
        ]);
    }
    /**
     * @Route("/back/list_commandee", name="commande_e_index_admin")
     */
    public function index_admin(CommandeERepository $commandeERepository): Response
    {$list_commandee = $commandeERepository->findAll();
        return $this->render('commande_e/back/index.html.twig', [
            'commande_es' => $list_commandee,
        ]);
    }

    /**
     * @IsGranted ("ROLE_USER")
     * @Route("/new/{id}", name="commande_e_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager,Evenement $evenement): Response
    {
        $commandeE = new CommandeE();
        $commandeE->setEvenement($evenement);

        $commandeE->setDateCreation(new \DateTime('now'));
        $commandeE->setAddressDestination('');
        $form = $this->createForm(CommandeEType::class, $commandeE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeE);
            $entityManager->flush();

            return $this->redirectToRoute('commande_e_index');
        }

        return $this->render('commande_e/new.html.twig', [
            'commande_e' => $commandeE,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/back/new", name="commande_e_new_admin")
     */
    public function new_admin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandeE = new CommandeE();
        $commandeE->setDateCreation(new \DateTime('now'));
        $commandeE->setAddressDestination('');
        $form = $this->createForm(CommandeEType::class, $commandeE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeE);
            $entityManager->flush();

            return $this->redirectToRoute('commande_e_index_admin');
        }

        return $this->render('commande_e/back/new.html.twig', [
            'commande_e' => $commandeE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_e_show", methods={"GET"})
     */
    public function show(CommandeE $commandeE): Response
    {
        return $this->render('commande_e/show.html.twig', [
            'commande_e' => $commandeE,
        ]);
    }
    /**
     * @Route("/back/{id}", name="commande_e_show_admin", methods={"GET"})
     */
    public function show_admin(CommandeE $commandeE): Response
    {
        return $this->render('commande_e/back/show.html.twig', [
            'commande_e' => $commandeE,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_e_edit")
     */
    public function edit(Request $request, CommandeE $commandeE,$id): Response
    {  $em = $this->getDoctrine()->getManager();
        $commandeE = $em->getRepository(CommandeE::class)->find($id);
        $form = $this->createForm(CommandeEType::class, $commandeE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('commande_e_index', ['id=>$id']);
        }

        return $this->render('commande_e/edit.html.twig', [
            'commande_e' => $commandeE,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/back/{id}/edit", name="commande_e_edit_admin")
     */
    public function edit_admin(Request $request, CommandeE $commandeE,$id): Response
    {  $em = $this->getDoctrine()->getManager();
        $commandeE = $em->getRepository(CommandeE::class)->find($id);
        $form = $this->createForm(CommandeEType::class, $commandeE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('commande_e_index_admin', ['id=>$id']);
        }

        return $this->render('commande_e/back/edit.html.twig', [
            'commande_e' => $commandeE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="commande_e_delete")
     */
    public function delete(Request $request, $id): Response
    {$em = $this->getDoctrine()->getManager();
        $commandee = $em->getRepository(CommandeE::class)->find($id);
        $em->remove($commandee);
        $em->flush();


        return $this->redirectToRoute('commande_e_index');
    }

    /**
     * @Route("/back/delete/{id}", name="commande_e_delete_admin")
     */
    public function delete_admin(Request $request, $id): Response
    {$em = $this->getDoctrine()->getManager();
        $commandee = $em->getRepository(CommandeE::class)->find($id);
        $em->remove($commandee);
        $em->flush();


        return $this->redirectToRoute('commande_e_index_admin');
    }
}
