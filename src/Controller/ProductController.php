<?php

namespace App\Controller;
use App\ProductType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $client = new Product();
        $client->setDesignation('Alouani');
        $client->setDateCreation(new \DateTime());
        $client->setDescription('Description 1');
        $client->setLabel('Label');
        $entityManager->persist($client);
        $entityManager->flush();
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * @Route("/newclient", name="newclient")
     */
    public function newclient(EntityManagerInterface $entityManager, \Symfony\Component\HttpFoundation\Request $request)
    {
        $client = new Product();
        $client->setDesignation('Alouani');
        $client->setDateCreation(new \DateTime());
        $client->setDescription('Description 1');
        $client->setLabel('Label');
        $form = $this->createForm(ProductType::class,$client);
        //$form->createView();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $client->getImageOfProduct();
            //dd($file->getClientOriginalName());
            $fileName = md5(uniqid().'.'.$file->guessExtension());
            $file->move($this->getParameter('upload_directory'),$file->getClientOriginalName());
            $client->setImageOfProduct($file->getClientOriginalName());
            $entityManager->persist($client);
            $entityManager->flush();
        }
        return $this->render('client/new.html.twig', [
            'controller_name' => 'ClientController',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/home", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(ProductRepository $repository){
        $clients = $repository->findAll();
        return $this ->render('pages/home.html.twig',array(
            'clients'=>$clients
        ));
    }

    /**
     * @Route("/about", name="about")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function about(){
        return $this ->render('pages/about.html.twig');
    }

    /**
     * @Route("/contact", name ="contact")
     */
    public function contact(){
        return $this->render('pages/contact.html.twig');

    }
    /**
     * @Route("/updateProduct", name="product_controller_product")
     */
    public function updateProduct(ProductRepository $productRepository){
        $product_to_update = $productRepository->find(3);
        //$img = imagecreatefromjpeg("/uploads/".$product_to_update->getImageOfProduct());
        $product_to_update->setImageOfProduct(null);
        $form = $this->createForm(ProductType::class,$product_to_update);
        return $this->render("client/update.html.twig",array("controller_name"=>"Product Controller","form"=>$form->createView()));

    }
}
