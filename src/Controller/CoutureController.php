<?php

namespace App\Controller;

use App\Entity\Couture;
use App\Form\CoutureType;
use App\Entity\ImageCouture;
use App\Repository\CoutureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoutureController extends AbstractController
{
    /**
     * @Route("/coutures", name="coutures_index")
     */
    public function index(CoutureRepository $repo): Response
    {
        //  On recupere le Repository de l'Entite Couture
        // $repo = $this->getDoctrine()->getRepository(Couture::class);

        // On recupere toute les produits de couture dans la BDD
        $coutures = $repo->findAll();


        return $this->render('couture/index.html.twig', [
            'coutures' => $coutures
        ]);
    }

    /**
     * Permet de créer un produit couture
     *
     * @Route("/coutures/new", name="coutures_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $couture = new Couture();

        // Simuler deux Images avant que lont fait rentre dans le formulaire 

        // $imageCouture = new ImageCouture();
        // $imageCouture->setUrl('http://placehold.it/400x200')
        //     ->setCaption('Titre 1');

        // $imageCouture2 = new ImageCouture();
        // $imageCouture2->setUrl('http://placehold.it/400x200')
        //     ->setCaption('Titre 2');

        // $couture->addImageCouture($imageCouture)
        //     ->addImageCouture($imageCouture2);

        $form = $this->createForm(CoutureType::class, $couture);

        // Gere le donner poste et envoier dans le formulaire a la BDD
        $form->handleRequest($request);

        // On verifie si le form a etait sumit et si il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // $manager = $this->getDoctrine()->getManager();

            // Foreach sur les image 
            // On passe sur chaque cutureImages
            foreach ($couture->getImageCoutures() as $imageCouture) {
                // On precise a l'image que elle appartien au produit Couture   
                $imageCouture->setCouture($couture);
                // Fait persister L'image en question 
                $manager->persist($imageCouture);
            }

            // On ajoute l'author de produit qui l'ajouter
            $couture->setAuthor($this->getUser());

            $manager->persist($couture);
            $manager->flush();

            // Message flash pour notifier l'utilisateur
            $this->addFlash('success', "L'produit <strong{$couture->getTitle()}</strong> a bien été enregistrée !");

            // On redirige ver la page qui permet de afficer une seul Produit
            return $this->redirectToRoute('coutures_show', [
                'slug' => $couture->getSlug()
            ]);
        }

        return $this->render('couture/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher le formulaire d'edition
     *
     * @Route("/coutures/{slug}/edit", name="coutures_edit")
     * @Security("is_granted('ROLE_USER') and user === couture.getAuthor()", message="Le
     produit ne vous appartient pas, vous ne pouvez pas le modifier !")
     * @return Response
     */
    public function edit(Couture $couture, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CoutureType::class, $couture);

        // Gere le donner poste et envoier dans le formulaire a la BDD
        $form->handleRequest($request);

        // On verifie si le form a etait sumit et si il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // $manager = $this->getDoctrine()->getManager();

            // Foreach sur les image 
            // On passe sur chaque cutureImages
            foreach ($couture->getImageCoutures() as $imageCouture) {
                // On precise a l'image que elle appartien au produit Couture   
                $imageCouture->setCouture($couture);
                // Fait persister L'image en question 
                $manager->persist($imageCouture);
            }
            $manager->persist($couture);
            $manager->flush();

            // Message flash pour notifier l'utilisateur
            $this->addFlash('success', "Les modification de produit <strong{$couture->getTitle()}</strong> on bien été enregistrée !");

            // On redirige ver la page qui permet de afficer une seul Produit
            return $this->redirectToRoute('coutures_show', [
                'slug' => $couture->getSlug()
            ]);
        }

        return $this->render('couture/edit.html.twig', [
            'form' => $form->createView(),
            'couture' => $couture
        ]);
    }


    /**
     * Permet de afficher une seule Produit
     * @Route("/coutures/{slug}", name="coutures_show")
     * @return Response
     */
    public function show(Couture $couture)
    {
        // Je récupère l'produit qui corespond au slug !
        // $couture = $repo->findOneBySlug($slug);

        return $this->render('couture/show.html.twig', [
            'couture' => $couture
        ]);
    }

    /**
     * Permet de supprimer un Produit
     *
     * @Route("/coutures/{slug}/delete", name="coutures_delete")
     * @Security("is_granted('ROLE_USER') and user == couture.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressourse")
     *
     * @param Couture $couture
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Couture $couture, EntityManagerInterface $manager) {
        // On supprime le produit via le manager
        $manager->remove($couture);
        $manager->flush();

        $this->addFlash(
            'success', 
            "Le produit <strong>{$couture->getTitle()}</strong> a bien été supprimée"

            );
        // on fait une redirection
        return $this->redirectToRoute("coutures_index");
    }
}
