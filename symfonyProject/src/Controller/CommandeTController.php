<?php

namespace App\Controller;

use App\Entity\CommandeT;
use App\Form\CommandeTType;
use App\Repository\CommandeTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/commandet")
 */
class CommandeTController extends AbstractController
{
    /**
     * @Route("/list_commandet", name="commande_t_index")
     */
    public function index(CommandeTRepository $commandeTRepository): Response
    {$list_commandet = $commandeTRepository->findAll();
        return $this->render('commande_t/index.html.twig', [
            'commande_ts' => $list_commandet,
        ]);
    }

    /**
     * @Route("/back/list_commandet", name="commande_t_index_admin")
     */
    public function index_admin(CommandeTRepository $commandeTRepository): Response
    {$list_commandet = $commandeTRepository->findAll();
        return $this->render('commande_t/back/index.html.twig', [
            'commande_ts' => $list_commandet,
        ]);
    }

    /**
     * @IsGranted ("ROLE_USER")
     * @Route("/new", name="commande_t_new")
     */
    public function new(Request $request): Response
    {
        $commandeT = new CommandeT();
        $commandeT->setDateCreation(new \DateTime('now'));
        $commandeT->setAddressDestination('');
        $form = $this->createForm(CommandeTType::class, $commandeT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($commandeT);
            $em->flush();

            return $this->redirectToRoute('commande_t_index');
        }

        return $this->render('commande_t/new.html.twig', [
            'commande_t' => $commandeT,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/back/new", name="commande_t_new_admin")
     */
    public function new_admin(Request $request): Response
    {
        $commandeT = new CommandeT();
        $commandeT->setDateCreation(new \DateTime('now'));
        $commandeT->setAddressDestination('');
        $form = $this->createForm(CommandeTType::class, $commandeT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($commandeT);
            $em->flush();

            return $this->redirectToRoute('commande_t_index_admin');
        }

        return $this->render('commande_t/back/new.html.twig', [
            'commande_t' => $commandeT,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_t_show")
     */
    public function show(CommandeT $commandeT): Response
    {
        return $this->render('commande_t/show.html.twig', [
            'commande_t' => $commandeT,
        ]);
    }


    /**
     * @Route("/back/{id}", name="commande_t_show_admin")
     */
    public function show_admin(CommandeT $commandeT): Response
    {
        return $this->render('commande_t/back/show.html.twig', [
            'commande_t' => $commandeT,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_t_edit")
     */
    public function edit($id,Request $request): Response
    {        $em = $this->getDoctrine()->getManager();
        $commandeT = $em->getRepository(CommandeT::class)->find($id);

        $form = $this->createForm(CommandeTType::class, $commandeT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('commande_t_index', array(
                'id' => $id)));
        }

        return $this->render('commande_t/edit.html.twig', [
            'commande_t' => $commandeT,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/{id}/edit", name="commande_t_edit_admin")
     */
    public function edit_admin($id,Request $request): Response
    {        $em = $this->getDoctrine()->getManager();
        $commandeT = $em->getRepository(CommandeT::class)->find($id);

        $form = $this->createForm(CommandeTType::class, $commandeT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('commande_t_index_admin', array(
                'id' => $id)));
        }

        return $this->render('commande_t/back/edit.html.twig', [
            'commande_t' => $commandeT,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="commande_t_delete")
     */
    public function delete($id,Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandet = $em->getRepository(CommandeT::class)->find($id);
        $em->remove($commandet);
        $em->flush();

        return $this->redirectToRoute('commande_t_index');
    }

    /**
     * @Route("/back/delete/{id}", name="commande_t_delete_admin")
     */
    public function delete_admin($id,Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandet = $em->getRepository(CommandeT::class)->find($id);
        $em->remove($commandet);
        $em->flush();

        return $this->redirectToRoute('commande_t_index_admin');
    }
}
