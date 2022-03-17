<?php

namespace App\Controller;
use App\Entity\Evenement;
use Stripe\Checkout\Session;
use Stripe\Stripe;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route ("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @param CommandeRepository $commandeRepository
     * @return Response
     * @IsGranted ("ROLE_USER")
     * @Route("/list_commande",name="index_c")
     */

    public function index(CommandeRepository $commandeRepository): Response
    {
        $list_commande = $commandeRepository->findAll();
        return $this->render('commande/index.html.twig', ['commandes' => $list_commande,
        ]);
    }


    /**
     * @param Request $req
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route ("/add_commande/{id}",name="add_c")
     */
    /*
    public function add_commande (Request $req): Response
{
    $command = new Commande();
    $form = $this->createForm(CommandeType::class, $command);
    $form->add('ajouter',SubmitType::class);
    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager= $this->getDoctrine()->getManager();
        $entityManager->persist($command);
        $entityManager->flush();
        $this->addFlash('success','commande à été crée');

        return $this->redirectToRoute('index_c', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('commande/new.html.twig', [
        'commandes' => $command,
        'form' => $form->createView(),
    ]);
}*/

    public function add_commande(Request $req,Evenement $evenement): Response
    {
        //Etape 1 : Préparation d'un objet vide.
        $commande = new Commande();
        $commande->setEvenement($evenement);
        $commande->setDateCommande(new \DateTime('now'));
        $commande->setAdresseDestination('');
        //Etape 2 : Création de formulaire
        $form = $this->createForm(CommandeType::class, $commande);
        //Etape 4 : Récuperation des données.
        $form->add('Ajouter', SubmitType::class);

        $form = $form->handleRequest($req);
        //Etape 5 : Validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            //Etape 6 : Création de l'entity manager
            $em = $this->getDoctrine()->getManager();
            //Etape 7 : Persister les données dans l'ORM
            $em->persist($commande);
            //Etape 8 : Sauvegarde des données dans la base des données
            $em->flush();
            return $this->redirectToRoute('index_c');
        }
        //Etape 3 : Envoi du formulaire.
        return $this->render('commande/new.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @return Response
     * @Route("/commande/{id}", name="show_c")
     */
    public function show( Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }



    /*
        public function edit($id,Commande $commande, Request $request,EntityManagerInterface $em): Response
        {

            $entityManager= $this->getDoctrine()->getManager();
            $commande = $em->getRepository(Commande::class)->find($id);
            //$commande->setDateCommande($request->request->get('date_commande'));
            $em = $this->getDoctrine()->getManager();
            //$entityManager->persist($commande);
            //$entityManager->flush();

            //$com=$rep->find($commande.getId())
            $form = $this->createForm(CommandeType::class, $commande);
            //$form->add('edit',SubmitType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $commande = $form->getData();
                $em->persist($commande);
                $em->flush();

                $this->addFlash('success', 'Commande is updated');

                return $this->redirectToRoute('index_c', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('commande/edit.html.twig', ['commande' => $commande, 'form' => $form->createView(),]);
            /*return $this->render('commande/edit.html.twig', [
                'commande' => $commande,
            ]);
        }*/

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/{id}/edit", name="edit_c")
     */

    public function edit($id, Commande $commande, Request $request): Response
    {
        //Etape 1 : Prépartion de l'entity manager
        $em = $this->getDoctrine()->getManager();
        //Etape 2 : Préparation de notre objet
        $commande = $em->getRepository(Commande::class)->find($id);
        //Etape 3 : Préparation de notre form
        $form = $this->createForm(CommandeType::class, $commande);
        //Etape 5 : Récupération du formulaire

        $form = $form->handleRequest($request);

        //Etape 6 : Validation du formulaire :
        if ($form->isSubmitted() && $form->isValid()) {
            //Etape 7 : Update dans la BD
            $em->flush();
            //Etape 8 : Redirection
            return $this->redirect($this->generateUrl('index_c', array(
                'id' => $id)));
        }
        return $this->render('commande/edit.html.twig', array(
            //Etape 4 : Envoi du form à l'utilisateur
            'form' => $form->createView()
        ));

    }

    /**
     * @param Request $request
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/commande/delete/{id}", name="delete_c")
     */

    public function delete($id, Request $request)
    {

        //$commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($id);
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('index_c');
    }

    /**
     * @return Response
     * @throws \Stripe\Exception\ApiErrorException
     * @Route ("/", name="checkout")
     */
    public function checkout(): Response
    {

        Stripe::setApiKey('sk_test_51KYa6PLo1XxC5WhZyg2Otw67MjDhJDnpHNl8xkmxy1NWrSfruIFMnyikQJFh4upAkIrCaISvyV7jlZy8vOEJBlte00MXskCbZg');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Commandeslis',
                        ],
                        'unit_amount' => 2000,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return $this->redirect($session->url, 303);
    }


    /**
     * @return Response
     * @Route ("/accueil/success_url", name="success_url")
     */

    public function successUrl( ): Response
    {
      // $pdfOptions->set('defaultFont', 'Arial');
      // $pdfOptions = new Options();

      // // Instantiate Dompdf with our options
      // $dompdf = new Dompdf($pdfOptions);

      // // Retrieve the HTML generated in our twig file
      // $html = $this->renderView('commande/success.html.twig', [
      //     'title' => "Welcome to our PDF Test"
      // ]);

      // // Load HTML to Dompdf
      // $dompdf->loadHtml($html);

      // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
      // $dompdf->setPaper('A4', 'portrait');

      // // Render the HTML as PDF
      // $dompdf->render();

      // // Output the generated PDF to Browser (force download)
      // $dompdf->stream("mypdf.pdf", [
      //     "Attachment" => true
      // ]);
        return $this->render('accueil/success.html.twig', []);
    }

    /**
     * @return Response
     * @Route ("/accueil/cancel_url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('accueil/cancel.html.twig', []);
    }
    /**
     * @return Response
     * @Route ("/facture", name="facture")
     */
    public function facture(): Response
    {
        return $this->render('accueil/facture.html.twig', [
        'controller_name' => 'CommandeController',
        ]);
    }

}
