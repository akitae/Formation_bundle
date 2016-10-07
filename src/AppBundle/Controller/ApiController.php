<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Acheteur;
use AppBundle\Entity\Objet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Acheteur controller.
 *
 * @Rest\Prefix("/api/")

 */
class ApiController extends FOSRestController
{

    /**
    * @Rest\Get("objet/get",name="api_objet")
     *
     * @ApiDoc(
     *     section="objet",
     *     description="Information sur les objets",
     *     output={"class" = "AppBundle\Entity\Objet"}
     * )
     *
    **/
    public function getObjetAction()
    {
        /** @var Objet $objet */
        $objet = $this->container->get('doctrine.orm.entity_manager')->getRepository(Objet::class)->findAll();
        //return new JsonResponse(['id' => $objet]);
        $view =$this->view($objet, Response::HTTP_OK);
        $view -> setFormat('json');
        return $this->handleView($view);


        /*return new JsonResponse ([
            'id' => $objet->getId(),
            'nom' => $objet->getName(),
            'prix' => $objet->getPrice(),
            'date' => $objet ->getDateVente(),
        ]);*/
    }


    /**
     * @Rest\Get("acheteur/get",name="api_acheteur")
     *
     * @ApiDoc(
     *     section="acheteur",
     *     description="Information sur les acheteurs",
     *     output={"class" = "AppBundle\Entity\Acheteur"}
     * )
     *
     **/
    public function getAcheteurAction(){
        /** @var Acheteur $acheteur */
            $acheteur = $this->container->get('doctrine.orm.entity_manager')->getRepository(Acheteur::class)->findAll();
            $view =$this->view($acheteur, Response::HTTP_OK);
            $view -> setFormat('json');
            return $this->handleView($view);

    }
}
