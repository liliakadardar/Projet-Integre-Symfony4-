<?php

namespace App\Controller;

use App\Entity\CategorieT;
use App\Entity\Transport;
use App\Form\CategorieTranspType;
use App\Form\TransportType;
use App\Repository\CategorieTRepository;
use App\Repository\TransportRepository;
use ContainerDW5rII5\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Knp\Component\Pager\PaginatorInterface;




class TransportController extends AbstractController
{
    /**
         * @Route("/transport", name="transport")
     */
    public function index(): Response
    {
        return $this->render('transport/affichertransportuser.html.twig', [
            'transports_name' => 'TransportRepository',
        ]);
    }
    /**
     *
     * @Route("/add", name="addTransport")
     */
    public function addTransport (Request $request)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();
            return $this->redirectToRoute('afficheS');
        }
        return $this->render('transport/_form.html.twig',['form' => $form->createView()]);
    }

    /**
     * @param TransportRepository $rep
     * @Route("/transport/edit/{id}", name="edittransport")

     */

    public function edit ($id,TransportRepository $rep, Request $request)
    {
        $transport = $rep->find($id);
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('edit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'transport a été updates');
            return $this->redirectToRoute('afficheS');
        }
        return $this->render('transport/edit.html.twig',['form' => $form->createView()]);
    }
    /**
     * @param TransportRepository $rep
     * @return Response
         * @Route("/transportshow", name="afficheS")
     */
    public function Afficher(TransportRepository $rep):Response
    {

        $transports= $this->getDoctrine()->getRepository(Transport::class)->findAll();
        return $this->render('transport/show.html.twig',[
            'transports'=>$transports
        ]);

    }

    /**
     * @Route("/transportd/{id}", name="transportd") * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($transport);
        $entityManager->flush();
        return $this->redirectToRoute('afficheS');
    }

    /**
     * @Route("/affichertransportfront",name="affichertransportfront")
     */
    public function afficherTransportsfront(TransportRepository $repository){
        $transport=$repository->findAll();
        return $this->render('transport/affichertransfront.html.twig'
            ,['transport'=>$transport]);

    }
    /**
     * @Route("/affichertransportadmin",name="affichertransportadmin")
     */
    public function afficherTransports(TransportRepository $repository, Request $request, PaginatorInterface $paginator){
        $transport=$repository->listTransportParDateDepart();
        $transport = $paginator->paginate(
            $transport,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/
        );
        return $this->render('transport/affichertransportback.html.twig'
            ,['tabletransport'=>$transport]);

    }
    /**
     *
     * @Route("/ajoutertransportadmin", name="ajoutertransportadmin")
     */
    public function ajoutertransportadmin (Request $request,\Swift_Mailer $mailer)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();
            $mail=[];


          //  $msg= $transport->getDateDep();

            $message = (new \Swift_Message("Vous avez ajouté un nouveau transport   "/*.$msg*/))

                ->setFrom('gocamp52@gmail.com')
                ->setTo('maryem.tayeb@esprit.tn')
                //message avec vue twig
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig'
                    ),
                    'text/html'
                ) ;

            $mailer->send($message);


            $this->addFlash('success', 'Transport ajouter');
            return $this->redirectToRoute('affichertransportadmin');
        }
        return $this->render('transport/ajoutertransportadmin.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/modifiertransport", name="modifiertransport", methods={"GET", "POST"})
     */
    public function modifierTransport(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransportType::class, $transport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->flush();
            $this->addFlash('info', 'Transport modifier');
            return $this->redirectToRoute('affichertransportadmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transport/modifiertransport.html.twig', [

            'categorie' => $transport,
            'form' => $form->createView(),

        ]);
    }

    /**
     *
     * @Route("/ajoutertransportuser", name="ajoutertransportuser")
     */
    public function ajoutertransportuser(Request $request)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();
            return $this->redirectToRoute('affichertransportfront');
        }
        return $this->render('transport/ajoutertransportuser.html.twig',['form' => $form->createView()]);
    }




    /**
     * @Route("/supprimertransport/{id}", name="supprimertransport")
     */
    public function supprimercategorie($id, Request $req): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Transport::class);
        $transport = $repo->find($id);
        $entityManager->remove($transport);
        $entityManager->flush();
        $this->addFlash('error', 'Transport supprimer');
        return $this->redirectToRoute('affichertransportadmin', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/stat", name="stat")
     */
    public function statAction(CategorieTRepository $repo)
    {
        $cat= $repo->findAll();
        $categorie= [];
        $coursCount= [];



        foreach($cat as $categorie){
            $categoriee[]=$categorie->getTypeTransport();
            $hotelVille[]= count($categorie->getTransport());
        }




        return $this->render('transport/dashbord.html.twig',
            [
                'categorieNom' => json_encode($categoriee),
                'transportcount' => json_encode($hotelVille),

            ]);


    }






}



