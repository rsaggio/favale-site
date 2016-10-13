<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Contato;

/**
 * Contato controller.
 *
 * @Route("/admin/contato")
 */
class ContatoController extends Controller
{
    /**
     * Lists all Contato entities.
     *
     * @Route("/", name="admin_contato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contatos = $em->getRepository('AppBundle:Contato')->findAll();

        return $this->render('contato/index.html.twig', array(
            'contatos' => $contatos,
        ));
    }

    /**
     * Finds and displays a Contato entity.
     *
     * @Route("/{id}", name="admin_contato_show")
     * @Method("GET")
     */
    public function showAction(Contato $contato)
    {

        return $this->render('contato/show.html.twig', array(
            'contato' => $contato,
        ));
    }
}
