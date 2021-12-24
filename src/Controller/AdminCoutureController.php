<?php

namespace App\Controller;


use App\Entity\Couture;
use App\Form\CoutureType;
use App\Repository\CoutureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCoutureController extends AbstractController
{

    /**
     * @Route("/admin/coutures", name="admin_coutures_index")
     * 
     */
    public function indexCouture(CoutureRepository $repo): Response
    {
        return $this->render('admin/couture/index.html.twig', [
            'coutures' => $repo->findAll()
        ]);
    }


    /**
     * Permet d'afficher le formulaire d'édition administration
     *
     * @Route("/admin/coutures/{id}/edit", name="admin_coutures_edit")
     * 
     * @param Couture $couture
     * @return void
     */
    public function editC(Couture $couture, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CoutureType::class, $couture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($couture);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'produit <strong>{$couture->getTitle()}</strong> a bien été enregistrée !"
            );
        }

        return $this->render('admin/couture/edit.html.twig', [
            'couture' => $couture,
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet de supprimer un produit
     * 
     * @Route("/admin/coutures/{id}/delete", name="admin_coutures_delete")
     *
     * @param Couture $couture
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Couture $couture, EntityManagerInterface $manager)
    {
        if (count($couture->getCommentCs()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'produit <strong>{$couture->getTitle()}</strong> 
                 car ce produit possède déjà des commentaires"
            );
        } else {
            $manager->remove($couture);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'produit <strong>{$couture->getTitle()}</strong> a bien été supprimée !"
            );
        }
        return $this->redirectToRoute("admin_coutures_delete");
    }
}
