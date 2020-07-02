<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Product;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes")
     */
    public function index(EntityManagerInterface $em,CommandeRepository $commandeRepository)
    {
        $commandes =  $commandeRepository->find(4);
        $p = $commandes->getProduct();
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandesController',
            'commande'=>$commandes
        ]);
    }
    /**
     * @Route ("/newOrder", name="commandes_new_order")
     */
    public function newOrder(ProductRepository $productRepository,Request $request,EntityManagerInterface $em){
        $cmd = new Commande();
        $cmd->setAdresseLivraison('Adresse de test');
        $cmd->setQte(2);
        //$p = new Product();
        $p = $productRepository->find(1);
        //$cmd->addIdProduct($p);
        $form = $this->createForm(CommandeType::class,$cmd);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $cmd->setProduct($p);
            $em->persist($cmd);
            $em->flush();
            return $this->redirectToRoute("commandes");

        }
        return $this->render('commandes/new.html.twig',array('form'=>$form->createView(),'controller_name' => 'CommandesController'));
    }
}
