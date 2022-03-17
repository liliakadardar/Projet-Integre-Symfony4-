<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="utilisateur_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('utilisateur/utilisateur.html.twig');
    }

    /**
     * @Route("/new", name="utilisateur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('utilisateur/utilisateur.html.twig', [
            'utilisateur' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$filename);
            $utilisateur->setImage($filename);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="utilisateur_delete", methods={"POST"})
     *
     */
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();

        }


        $this->container->get('security.token_storage')->setToken(null);
        $this->container->get('session')->invalidate();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }


/**
 * @Route("/users/pass/modifier", name="users_pass_modifier")
 */
public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
{
    if($request->isMethod('POST')){
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        // On vérifie si les 2 mots de passe sont identiques
        if($request->request->get('pass') == $request->request->get('pass2')){
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
            $em->flush();
            $this->addFlash('message', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }else
        {
            $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
        }
    }

    return $this->render('utilisateur/EditPass.html.twig');
}

    /**
     * @Route("/admin/utilisateurs", name="utilisateur_showALL", methods={"GET"})
     */

    public function showALL(UtilisateurRepository $repository, PaginatorInterface $paginator,Request $request): Response
    {
        $utilisateurs=$repository->listUtilisateurTri();
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository(Utilisateur::class)->findAll();

        $utilisateurs = $paginator->paginate(
            $utilisateurs,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*limit per page*/
        );
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }








}