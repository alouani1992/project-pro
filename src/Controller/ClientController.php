<?php

namespace App\Controller;
use App\clientType;
use App\Entity\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $client = new Client();
        $client->setNom('Alouani');
        $client->setDateNais(new \DateTime());
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
        $client = new Client();
        $client->setNom('Alouani');
        $client->setDateNais(new \DateTime());
        $form = $this->createForm(clientType::class,$client);
        //$form->createView();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
    public function home(){
        return $this ->render('pages/home.html.twig');
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
}
