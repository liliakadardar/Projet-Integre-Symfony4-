<?php

namespace App\Controller;

use App\Entity\CommandeM;
use App\Entity\Materiel;
use App\Form\CommandeMType;
use App\Repository\CommandeMRepository;
use ContainerOKqm40m\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/commandem")
 */
class CommandeMController extends AbstractController
{
    /**
     * @Route("/list_commandem", name="commande_m_index")
     */
    public function index(CommandeMRepository $commandeMRepository): Response
    {$list_commandeM = $commandeMRepository->findAll();

        return $this->render('commande_m/index.html.twig', [
            'commande_ms' => $list_commandeM,
        ]);
    }
    /**
     * @Route("/back/list_commandem", name="commande_m_index_admin")
     */
    public function index_Admin (CommandeMRepository $commandeMRepository,Request $request, PaginatorInterface $paginator): Response
    {$list_commandeM = $commandeMRepository->findAll();
        $list_commandeM = $paginator->paginate(
            $list_commandeM,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/
        );
        return $this->render('/commande_m/back/index.html.twig', [
            'commande_ms' => $list_commandeM,
        ]);
    }
    /**
     * @Route("/new/{id}", name="commande_m_new")
     */
    public function new(Request $request,Materiel $materiel): Response
    {
        $commandeM = new CommandeM();
        $commandeM->getMateriel($materiel);
        $commandeM->setDateCreation(new \DateTime('now'));
        $commandeM->setAddressDestination('');

        $commandeM-> setQuantite('0');
        $form = $this->createForm(CommandeMType::class, $commandeM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandeM);
            $em->flush();

            return $this->redirectToRoute('commande_m_index');
        }

        return $this->render('commande_m/new.html.twig', [
            'commande_m' => $commandeM,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/back/new", name="commande_m_new_admin")
     */
    public function new_admin(Request $request): Response
    {
        $commandeM = new CommandeM();
        $commandeM->setDateCreation(new \DateTime('now'));
        $commandeM->setAddressDestination('');

        $commandeM-> setQuantite('0');
        $form = $this->createForm(CommandeMType::class, $commandeM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandeM);
            $em->flush();

            return $this->redirectToRoute('commande_m_index_admin');
        }

        return $this->render('commande_m/back/new.html.twig', [
            'commande_m' => $commandeM,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="commande_m_show")
     */
    public function show(CommandeM $commandeM): Response
    {
        return $this->render('commande_m/show.html.twig', [
            'commande_m' => $commandeM,
        ]);
    }
    /**
     * @Route("/back/{id}", name="commande_m_show_admin")
     */
    public function show_admin(CommandeM $commandeM): Response
    {
        return $this->render('commande_m/back/show.html.twig', [
            'commande_m' => $commandeM,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_m_edit")
     */
    public function edit(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandeM = $em->getRepository(CommandeM::class)->find($id);

        $form = $this->createForm(CommandeMType::class, $commandeM);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em>flush();

        }

        return $this->render('commande_m/edit.html.twig', [
            'commande_m' => $commandeM,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/back/{id}/edit", name="commande_m_edit_admin")
     */
    public function edit_admin(Request $request,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandeM = $em->getRepository(CommandeM::class)->find($id);

        $form = $this->createForm(CommandeMType::class, $commandeM);

        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em>flush();

            return $this->redirectToRoute('commande_m_index_admin', ['id'=>$id]);
        }

        return $this->render('commande_m/back/edit.html.twig', [
            'commande_m' => $commandeM,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="commande_m_delete")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandeM = $em->getRepository(CommandeM::class)->find($id);
        $em->remove($commandeM);
        $em->flush();

        return $this->redirectToRoute('commande_m_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/back/delete/{id}", name="commande_m_delete_admin")
     */
    public function delete_admin(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandeM = $em->getRepository(CommandeM::class)->find($id);
        $em->remove($commandeM);
        $em->flush();

        return $this->redirectToRoute('commande_m_index_admin');
    }
}
