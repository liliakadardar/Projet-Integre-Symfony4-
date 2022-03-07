<?php

namespace App\Controller;

use App\Entity\CategorieE;
use App\Entity\Evenement;
use App\Form\CategorieEType;
use App\Form\EvenementType;
use App\Repository\CategorieERepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(EvenementRepository $evenement): Response
    {
        $events = $evenement->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'title' => $event->getNomE(),
                'description' => $event->getDescription(),
                'start' => $event->getDatedeb()->format('Y-m-d'),
                'end' => $event->getDatefin()->format('Y-m-d'),
                'categorie' => $event->getCategoryId(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('calendar/index.html.twig', compact('data'));
    }

    /**
     * @Route("/admin/calendar", name="calendaradmin")
     */
    public function indexadmin(EvenementRepository $evenement): Response
    {
        $events = $evenement->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'title' => $event->getNomE(),
                'description' => $event->getDescription(),
                'start' => $event->getDatedeb()->format('Y-m-d'),
                'end' => $event->getDatefin()->format('Y-m-d'),
                'categorie' => $event->getCategoryId(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('calendar/indexadmin.html.twig', compact('data'));
    }
}