<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Acheteur;
use Sedona\SBORuntimeBundle\Controller\BaseCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Objet;
use AppBundle\Form\ObjetType;
use FOS\RestBundle\Controller\FOSRestController;
/**
 * Objet controller.
 *
 * @Route("/objet")
 */
class ObjetController extends BaseCrudController
{
    /**
     * Lists all Objet entities.
     *
     * @Route("/", name="objet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $objets = $em->getRepository('AppBundle:Objet')->findAll();

        return $this->render('objet/index.html.twig', array(
            'objets' => $objets,
        ));
    }

    /**
     * Creates a new Objet entity.
     *
     * @Route("/new", name="objet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $objet = new Objet();
        $form = $this->createForm('AppBundle\Form\ObjetType', $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();

            return $this->redirectToRoute('objet_show', array('id' => $objet->getId()));
        }

        return $this->render('objet/new.html.twig', array(
            'objet' => $objet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Objet entity.
     *
     * @Route("/{id}", name="objet_show", requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function showAction(Objet $objet)
    {
        $deleteForm = $this->createDeleteForm($objet);

        return $this->render('objet/show.html.twig', array(
            'objet' => $objet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Objet entity.
     *
     * @Route("/{id}/edit", name="objet_edit", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Objet $objet)
    {
        $deleteForm = $this->createDeleteForm($objet);
        $editForm = $this->createForm('AppBundle\Form\ObjetType', $objet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();

            return $this->redirectToRoute('objet_edit', array('id' => $objet->getId()));
        }

        return $this->render('objet/edit.html.twig', array(
            'objet' => $objet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Objet entity.
     *
     * @Route("/{id}/delete", name="objet_delete", requirements={"id":"\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Objet $objet)
    {
        $form = $this->createDeleteForm($objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($objet);
            $em->flush();
        }

        return $this->redirectToRoute('objet_index');
    }

    /**
     * Creates a form to delete a Objet entity.
     *
     * @param Objet $objet The Objet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Objet $objet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('objet_delete', array('id' => $objet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * JSON call for datatable to list all Object entities.
     *
     * @Route("/datatable", name="objet_datatable")
     * @Method("GET")
     */
    public function DataTableAction(){
        return $this->manageDatatableJson();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/searchAcheteur", name="search_acheteur")
     */

    public function searchAcheteurAction(Request $request){
        return $this-> searchSelect2($request, Acheteur::class,'name');
    }
}
