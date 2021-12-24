<?php

namespace App\Controller;

use App\Entity\Bijoux;
use App\Form\BijouxType;
use App\Repository\BijouxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBijouxController extends AbstractController
{
    /**
     * @Route("/admin/bijouxs", name="admin_bijouxs_index")
     * 
     */
    public function indexBijoux(BijouxRepository $repo): Response
    {
        return $this->render('admin/bijoux/index.html.twig', [
            'bijouxs' => $repo->findAll()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition administration
     *
     * @Route("/admin/bijouxs/{id}/edit", name="admin_bijouxs_edit")
     * 
     * @param Bijoux $bijoux
     * @return void
     */
    public function edit(Bijoux $bijoux, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BijouxType::class, $bijoux);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($bijoux);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'produit <strong>{$bijoux->getTitle()}</strong> a bien été enregistrée !"
            );
        }

        return $this->render('admin/bijoux/edit.html.twig', [
            'bijoux' => $bijoux,
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet de supprimer un produit
     * 
     * @Route("/admin/bijouxs/{id}/delete", name="admin_bijouxs_delete")
     *
     * @param Bijoux $bijoux
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Bijoux $bijoux, EntityManagerInterface $manager)
    {
        if (count($bijoux->getCommentBs()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'produit <strong>{$bijoux->getTitle()}</strong> 
                car ce produit possède déjà des commentaires"
            );
        } else {
            $manager->remove($bijoux);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'produit <strong>{$bijoux->getTitle()}</strong> a bien été supprimée !"
            );
        }

        return $this->redirectToRoute('admin_bijouxs_delete');
    }
}
