<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Newsletter;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="homeBlog")
     */
    public function listaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findNews();
        $autores = $em->getRepository('AppBundle:Autor')->findAll();

        return $this->render('AppBundle:Blog:lista.html.twig', array(
            "posts" => $posts,
            "autores" => $autores
        ));
    }

    /**
     * @Route("/post/{slug}", name="detalhePost")
     */
    public function detalheAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository('AppBundle:Post');
        $post = $postRepository->findOneBySlug($slug);
        $posts = $postRepository->findNews();
        $autores = $em->getRepository('AppBundle:Autor')->findAll();

        return $this->render('AppBundle:Blog:detalhe.html.twig', array(
           "post" => $post,
           "posts" => $posts,
           "autores" => $autores
        ));
    }

    /**
     * @Route("/busca", name="buscaPost")
     */
    public function buscaAction(Request $request)
    {
        $search = $request->get('search');
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findByTitulo($search);
        $autores = $em->getRepository('AppBundle:Autor')->findAll();

        return $this->render('AppBundle:Blog:lista.html.twig', array(
           "posts" => $posts,
           "autores" => $autores
        ));
    }

     /**
     * @Route("autor/{nome}", name="buscaPorAutor")
     */
    public function buscaPorAutorAction($nome)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findByAutorNome($nome);
        $autores = $em->getRepository('AppBundle:Autor')->findAll();

        return $this->render('AppBundle:Blog:lista.html.twig', array(
           "posts" => $posts,
           "autores" => $autores
        ));
    }


    /**
     * @Route("newsletter", name="newsletter")
     */
    public function cadastrarNewsletter(Request $request) {

        $email = $request->get('email');

        $newsletter = new Newsletter();
        $newsletter->setEmail($email);
        $newsletter->setDataCadastro(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($newsletter);
        $em->flush();

        return $this->redirectToRoute("homeBlog");

    }
}
