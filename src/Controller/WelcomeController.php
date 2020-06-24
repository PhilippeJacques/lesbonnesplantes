<?php

namespace App\Controller;

use App\Repository\PlantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    /**
     * @Route("/plant", name="publications")
     */
    public function yes(PlantRepository $repository) : Response
    {
        $plant=$repository->findAll();
        //$this->em->flush();
        return $this->render('hello_page.html.twig', [
            //'controller_name' => 'WelcomeController',
            'plant'=>$plant
        ]);
    }
}
