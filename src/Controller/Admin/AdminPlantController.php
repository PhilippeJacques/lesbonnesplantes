<?php
 namespace  App\Controller\Admin;


 use App\Entity\Plant;
 use App\Form\PlantType;

 use App\Repository\PlantRepository;
 use Doctrine\ORM\EntityManager;
 use Symfony\Component\HttpFoundation\Request;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;

 class AdminPlantController extends AbstractController{

     /**
      * @var PlantRepository
      */
     private $repository;
     /**
      * @var EntityManager
      */
     private $em;

     public function __construct(PlantRepository $repository,EntityManagerInterface $em)
     {
         $this->repository = $repository;
         $this->em = $em;
     }

     /**
      * @Route("/admin", name="admin.plant.index" )
      * @return \Symfony\Component\HttpFoundation\Response
      */
     public function index(){
    $plant = $this->repository->findAll();
    return $this->render('plant/index.html.twig',compact("plant"));
     }

     /**
      * @Route("admin/bien/create", name="admin.plant.new")
      */
    public function new(Request $request){
        $plant = new Plant();
        $form =  $this->createForm(plantType::class,$plant);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($plant);
            $this->em->flush();
            return $this->redirectToRoute('admin.plant.index');
        }
        return $this->render('plant/new.html.twig',
            ['plant' =>$plant,
                'form'=>$form->createView()]);
    }


     /**
      * @Route("/admin/{id}",name="admin.plant.edit", methods="GET|POST")
      * @param Request $request
      * @param Plant $plant
      */
     public function edit(Plant $plant, Request $request){
         $form =  $this->createForm(plantType::class,$plant);
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){
             $this->em->flush();
             return $this->redirectToRoute('admin.plant.index');
         }
         return $this->render('plant/edit.html.twig',
         ['plant' =>$plant,
         'form'=>$form->createView()]);

     }

     /**
      * @Route("/admin/{id}",name="admin.plant.delete", methods="DELETE")
      * @param Plant $plant
      * @return \Symfony\Component\HttpFoundation\RedirectResponse
      */
     public function delete(Plant $plant, Request $request){
         if($this->isCsrfTokenValid('delete'. $plant->getId(), $request->get('_token'))){
             $this->em->remove($plant);
             $this->em->flush();

           //  return new Response('Suppression');
         }

         return $this->redirectToRoute('admin.plant.index');
     }
 }