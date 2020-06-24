<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Plant;
use App\Entity\PlantSearch;
use App\Form\ContactSearchType;
use App\Form\PlantSearchType;

use App\Notification\ContactNotification;
use App\Repository\PlantRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PlantController extends AbstractController
{
    /**
     * @var PlantRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(PlantRepository $repository,EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/publication", name="plant.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new PlantSearch();


       $form = $this->createForm(PlantSearchType::class, $search);
       //$planted = $this->repository->findAll();
        $form -> handleRequest($request);
        $planted = $paginator->paginate($this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), 12
        );
        return $this->render('welcome/index2.html.twig', [
            'controller_name' => 'PlantController',
            'planted'=> $planted,
            'form' => $form ->createView()
        ]);
    }

    /**
     *  * @Route("/plant/{slug}.{id}", name="plant.show",requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Plant $plant,string $slug, Request $request, ContactNotification $contactNotification):Response{



        if($plant->getslug() !== $slug){
          return  $this->redirectToRoute('plant.show',
                ['id'=> $plant->getId(),
                    'slug'=>$plant->getslug()],301
            );
        }

        $contact = new Contact();
        $contact->setPlant($plant);
        $form = $this->createForm(ContactSearchType::class,$contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contactNotification->notify($contact);
            $this->addFlash('success','votre formulaire à bien été envoyer');
            return $this->redirectToRoute('plant.show',
                ['id'=> $plant->getId(),
                    'slug'=>$plant->getslug()]);
        }
        return $this->render('plant/show.html.twig',[
            'plant'=>$plant,
            'controller_name' => 'PlantController',
        'form'=>$form->createView()]);
    }
}
