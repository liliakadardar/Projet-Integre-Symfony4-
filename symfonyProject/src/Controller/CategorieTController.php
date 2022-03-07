<?php

namespace App\Controller;



use App\Entity\CategorieT;
use App\Form\CategorieTranspType;
use App\Repository\CategorieTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieTController extends AbstractController
{
    /**
     * @Route("/categorie/t", name="categorie_t")
     */
    public function index(): Response
    {
        return $this->render('categorie_t/index.html.twig', [
            'controller_name' => 'CategorieTController',
        ]);
    }

    /**
     * @Route("/affichercategorietadmin",name="affichercategorie")
     */
    public function afficherRegions(CategorieTRepository $repository){
        $categorie=$repository->listCategorieParType();
        return $this->render('categorie_t/affichercategorie.html.twig'
            ,['tablecategorie'=>$categorie]);

    }

    /**
     * @Route("/ajoutercategorie", name="ajoutercategorie", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new CategorieT();
        $form = $this->createForm(CategorieTranspType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $new=$form->getData();
            $imageFile = $form->get('image_transport')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'uploads\region',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $categorie->setImageTransport($newFilename);
            }
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Categorie ajouter');

            return $this->redirectToRoute('affichercategorie');
        }

        return $this->render('categorie_t/ajoutercategorietransport.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/modifiercategorie", name="modifiercategorie", methods={"GET", "POST"})
     */
    public function modifierRegion(Request $request, CategorieT $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieTranspType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image_transport')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'uploads\region',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $categorie->setImageTransport($newFilename);
            }
            $entityManager->flush();
            $this->addFlash('info', 'Categorie modifier');

            return $this->redirectToRoute('affichercategorie', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_t/modifierCategorie.html.twig', [
            'image' => $categorie->getImageTransport(),
            'categorie' => $categorie,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/supprimercategorie/{id}", name="supprimercategorie")
     */
    public function supprimercategorie($id, Request $req): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(CategorieT::class);
        $categorie = $repo->find($id);
        $entityManager->remove($categorie);
        $entityManager->flush();
        $this->addFlash('error', 'Categorie supprimer');

        return $this->redirectToRoute('affichercategorie', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/affichercategorieuser",name="affichercategorieuser")
     */
    public function afficherRegionsUser(CategorieTRepository $repository){
        $categorie=$repository->findAll();
        return $this->render('categorie_t/affichercategoriefront.html.twig'
            ,['tablecategorie'=>$categorie]);

    }

    /**
     * @Route("/transportfront/{id}",name="get_transport")
     */

    public function getCategorieById (CategorieTRepository $repository, Request $request)
    {
        $id = $request->get('id');

        $transport = $repository->findOneBy(['id' => $id]);




        return $this->render("transport/affichertransportuser.html.twig",['transport' => $transport]) ;

    }





}
