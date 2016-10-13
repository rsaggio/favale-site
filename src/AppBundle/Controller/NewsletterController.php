<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Newsletter;

/**
 * Newsletter controller.
 *
 * @Route("/admin/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * Lists all Newsletter entities.
     *
     * @Route("/", name="admin_newsletter_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsletters = $em->getRepository('AppBundle:Newsletter')->findAll();

        return $this->render('newsletter/index.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

    /**
     * Finds and displays a Newsletter entity.
     *
     * @Route("/{id}", name="admin_newsletter_show")
     * @Method("GET")
     */
    public function showAction(Newsletter $newsletter)
    {

        return $this->render('newsletter/show.html.twig', array(
            'newsletter' => $newsletter,
        ));
    }
}
