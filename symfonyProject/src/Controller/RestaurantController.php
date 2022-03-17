<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use App\Repository\RegionRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\RestaurantSearch;
use App\Form\RestaurantSearchType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;


class RestaurantController extends AbstractController
{
     
    /**
     * @Route("/afficherrestaurant", name="restaurant_index", methods={"GET"})
     */
    public function showBack(RestaurantRepository $restaurantRepository, Request $request , PaginatorInterface $paginator): Response
    {
        $restaurants=$this->getDoctrine()->getRepository(Restaurant::class)->findAll();
        $restaurants = $paginator->paginate(
            $restaurants,  
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/   
       );
       $msg = "";
       if($request->get("actions") == "delete")
       {
           $msg = "Deleted successfully!";
       }
        return $this->render('restaurant/show_back.html.twig', [
            'restaurants' => $restaurants,
            'msg' => $msg

        ]);
    }

    /**
     * @Route("/user", name="restaurant_index_front", methods={"GET"})
     */
    public function showFront(Request $request,RestaurantRepository $restaurantRepository,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Restaurant::class)->findAll();
        $restaurant = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('restaurant/show_front.html.twig', [
            'restaurants' => $restaurant,
        ]);
    }

    /**
     * @Route("/show/{id}", name="restaurant_show_f", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/new", name="restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $restaurant->setImage($newFilename);
            }
            $entityManager->persist($restaurant);
            $entityManager->flush();
            $flashy->success('Restaurant Added', 'http://your-awesome-link.com');

            return $this->redirectToRoute('restaurant_index');
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="restaurant_show", methods={"GET"})
    //  */
    // public function show(Restaurant $restaurant): Response
    // {
    //     return $this->render('restaurant/show.html.twig', [
    //         'restaurant' => $restaurant,
    //     ]);
    // }



    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant)
        ->add('image', FileType::class, [
            'mapped' => false,

            'constraints' => [
                new File([
                    'mimeTypes' => [
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'vérifier votre fichier',
                ])
            ],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $restaurant->setImage($newFilename);
            }
            $entityManager->flush();
            $flashy->primaryDark('Restaurant Updated!', 'http://your-awesome-link.com');

            return $this->redirectToRoute('restaurant_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('restaurant/edit.html.twig', [
            'image' => $restaurant->getImage(),
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("resto/delete/{id}", name="restaurant_delete")
     */
    public function delete($id, Request $req,FlashyNotifier $flashy): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $restaurantRepository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $restaurantRepository->find($id);
        $entityManager->remove($restaurant);
        $entityManager->flush();
        $flashy->warning('Restaurant Deleted!', 'http://your-awesome-link.com');

        //return $this->redirect($this->generateUrl("restaurant_index", array("actions"=>"delete")));

        return $this->redirectToRoute('restaurant_index', array("actions"=>"delete"), Response::HTTP_SEE_OTHER);
    }
    /**
     * @route("/stat",name="sta")
     */
    public function statisti(RestaurantRepository $repository,RegionRepository $regionRepository)
    {

        $opp=$repository->findAll();


        return $this->render("restaurant/statistique.html.twig",['Reg'=>$opp]);

    }
    /**
     * @Route("/list", name="rest_pdf", methods={"GET"})
     */
    public function pdf(RestaurantRepository $restaurantRepository,FlashyNotifier $flashy): Response
    {



        $pdfOptions = new Options();
        $restaurant = new Restaurant();
        $pdfOptions->set('defaultFont', 'Arial');
        $options= new Options();
        $options->setIsRemoteEnabled(true);
        $options-> set('is remotedEnabed' , TRUE) ;
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
       
            $image = $form->get('image')->getData();

            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $restaurant->setImage($newFilename);
            }

            $flashy->success('Exported!', 'http://your-awesome-link.com');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($image);
        $dompdf->output();
        $restaurant = $restaurantRepository->findAll();
   


         //Retrieve the HTML generated in our twig file
        
         $html = $this->renderView('restaurant/listepdf.html.twig', [
            'restaurants' => $restaurant,

        ]);


        $options-> set('is remotedEnabed' , TRUE) ;

       

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        $options = new Options(); 

        $pdf=new DOMPDF($options);
       

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
       
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
       
        $dompdf->stream("listepdf.pdf", [
            "Attachment" => true
        ]);
    


    }

     /**
     * @Route("/restaurant/ajax_search", name="ajax_search" ,methods={"GET"})
     * @param Request $request
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     */
    public function searchAction(Request $request,RestaurantRepository $restaurantRepository) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $restaurants =$restaurantRepository->SearchNom($requestString);
        if(!$restaurants) {
            $result['restaurants']['error'] = "restaurant non trouvée ";
        } else {
            $result['restaurants'] = $this->getRealEntities($restaurants);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($restaurants){
        foreach ($restaurants as $restaurant){
            $realEntities[$restaurant->getId()] = [$restaurant->getImage(),$restaurant->getNomResto()];

        }
        return $realEntities;
    }
      /**
     * @Route("/triH", name="tri")
     */
    public function Tri(Request $request, RestaurantRepository $repository,FlashyNotifier $flashy): Response
    {
        // Retrieve the entity manager of Doctrine
        $order = $request->get('type');
        if ($order == "Croissant") {
            $restaurants = $repository->tri_asc();
        } else {

            $restaurants = $repository->tri_desc();
        }
        $flashy->primaryDark('list ordered', 'http://your-awesome-link.com');

        // Render the twig view
        return $this->render('restaurant/show_back.html.twig', ['restaurants' => $restaurants
        ]);
    }
}
