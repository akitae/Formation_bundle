<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Acheteur;
use AppBundle\Form\AcheteurType;

/**
 * Acheteur controller.
 *
 * @Route("/acheteur")
 */
class AcheteurController extends Controller
{
    /**
     * Lists all Acheteur entities.
     *
     * @Route("/", name="acheteur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $acheteurs = $em->getRepository('AppBundle:Acheteur')->findAll();

        return $this->render('acheteur/index.html.twig', array(
            'acheteurs' => $acheteurs,
        ));
    }

    /**
     * Creates a new Acheteur entity.
     *
     * @Route("/new", name="acheteur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $acheteur = new Acheteur();
        $form = $this->createForm('AppBundle\Form\AcheteurType', $acheteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($acheteur);
            $em->flush();

            return $this->redirectToRoute('acheteur_show', array('id' => $acheteur->getId()));
        }

        return $this->render('acheteur/new.html.twig', array(
            'acheteur' => $acheteur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Acheteur entity.
     *
     * @Route("/{id}", name="acheteur_show")
     * @Method("GET")
     */
    public function showAction(Acheteur $acheteur)
    {
        $deleteForm = $this->createDeleteForm($acheteur);

        return $this->render('acheteur/show.html.twig', array(
            'acheteur' => $acheteur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Acheteur entity.
     *
     * @Route("/{id}/edit", name="acheteur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Acheteur $acheteur)
    {
        $deleteForm = $this->createDeleteForm($acheteur);
        $editForm = $this->createForm('AppBundle\Form\AcheteurType', $acheteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($acheteur);
            $em->flush();

            return $this->redirectToRoute('acheteur_edit', array('id' => $acheteur->getId()));
        }

        return $this->render('acheteur/edit.html.twig', array(
            'acheteur' => $acheteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Acheteur entity.
     *
     * @Route("/{id}", name="acheteur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Acheteur $acheteur)
    {
        $form = $this->createDeleteForm($acheteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($acheteur);
            $em->flush();
        }

        return $this->redirectToRoute('acheteur_index');
    }

    /**
     * Creates a form to delete a Acheteur entity.
     *
     * @param Acheteur $acheteur The Acheteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Acheteur $acheteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('acheteur_delete', array('id' => $acheteur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
