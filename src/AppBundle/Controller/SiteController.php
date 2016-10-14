<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contato;

class SiteController extends Controller
{
    
    /**
     * @Route("/", name="homeSite")
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $professors = $em->getRepository('AppBundle:Professor')->findAll();
        $banners = $em->getRepository('AppBundle:BannerPrincipal')->findAll();
        $depoimentos = $em->getRepository('AppBundle:Depoimento')->findAll();

        return $this->render('AppBundle:Site:home.html.twig', array(
            "professors" => $professors,
            "banners" => $banners,
            "depoimentos" => $depoimentos
        ));
    }

    /**
     * @Route("/parceiros", name="parceiros")
     */
    public function parceirosAction()
    {
        $em = $this->getDoctrine()->getManager();
         $parceiros = $em->getRepository('AppBundle:Parceiro')->findAll();
        return $this->render('AppBundle:Site:parceiros.html.twig', array(
            "parceiros" => $parceiros
        ));
    }

    /**
     * @Route("/contato", name="formContato")
     * @Method({"GET", "POST"})
     */
    public function contatoAction(Request $request)
    {
        $contato = new Contato();
        $form = $this->createForm('AppBundle\Form\ContatoType', $contato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contato->setData(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($contato);
            $em->flush();

            $this->addFlash('notice', 'Email enviado com sucesso');

        }

        return $this->render('AppBundle:Site:contato.html.twig', array(
            'form' => $form->createView(),
            'contato' => $contato

        ));
    }

}
