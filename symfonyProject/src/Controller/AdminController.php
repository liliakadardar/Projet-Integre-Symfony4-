<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class AdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/profileAdmin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/{id}", name="admin_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('admin/profileAdmin.html.twig', [
            'utilisateur' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/modifier/{id}",name="modifierUtilisateur")
     * Method({"GET", "POST"})
     */
    public function update($id, Request $request) : Response
    {
        $utilisateur = new utilisateur();
        $utilisateur = $this->getDoctrine()
            ->getRepository(utilisateur::class)
            ->find($id);


        $form = $this->createformbuilder($utilisateur)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',TextType::class)
            ->add('num_tel',IntegerType::class)

            ->add('image',FileType::class,[
                'mapped'=> false,
                'label'=>' Télécharger une image'

            ])
            ->add('Modifier',SubmitType::class, [
                "label_format"=>" modifier ",
                "attr" => [
                    "class" => "btn btn-primary"

                ]]
            )

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            $filename = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('image_directory'),$filename);

            $utilisateur->setImage($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('utilisateur_showALL');
        }
        return $this->render('utilisateur/EditMembreAdmin.html.twig', [
            'form' => $form->createView(),


        ]);
    }







    /**
     * @Route("/Delete/{id}" ,name="delete_admin")
     *
     */
    public function Deleteadmin(Request $request,$id)
    {
        $utilisateur = $this->getDoctrine()
            ->getRepository(utilisateur::class)
            ->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($utilisateur);
        $entityManager->flush();


        return $this->redirectToRoute('utilisateur_showALL');

    }


    /**
     * @Route("utilisateur/{id}/desactiver", name="desactiver-user")
     */
    public function desactiverUser($id)
    {
        $user = $this->getDoctrine()->getRepository(utilisateur::class)->find($id);
        $user->setIsVerified(0);
        $user->setRoles(["ROLE_USER", "ROLE_BLOQ"]);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("utilisateur/{id}/activer", name="activer-user")
     */
    public function activerUser($id)
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $user->setIsVerified(1);
        $user->setRoles(["ROLE_USER"]);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }







}
