<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Autor;
use AppBundle\Form\AutorType;
use AppBundle\Services\UploadService;

/**
 * Autor controller.
 *
 * @Route("/admin/autor", service="autor_controller")
 */
class AutorController extends Controller
{
    private $uploader;

    public function __construct($container,UploadService $uploader) {
        $this->container = $container;
        $this->uploader = $uploader;
    }
    /**
     * Lists all Autor entities.
     *
     * @Route("/", name="autor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $autors = $em->getRepository('AppBundle:Autor')->findAll();

        return $this->render('autor/index.html.twig', array(
            'autors' => $autors,
        ));
    }

    /**
     * Creates a new Autor entity.
     *
     * @Route("/new", name="autor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $autor = new Autor();
        $form = $this->createForm('AppBundle\Form\AutorType', $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imagem = $autor->getArquivoFoto();

            $imagem = $this->uploader->upload($imagem);

            $autor->setFoto($imagem);

            $em = $this->getDoctrine()->getManager();
            $em->persist($autor);
            $em->flush();

            return $this->redirectToRoute('autor_show', array('id' => $autor->getId()));
        }

        return $this->render('autor/new.html.twig', array(
            'autor' => $autor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Autor entity.
     *
     * @Route("/{id}", name="autor_show")
     * @Method("GET")
     */
    public function showAction(Autor $autor)
    {
        $deleteForm = $this->createDeleteForm($autor);

        return $this->render('autor/show.html.twig', array(
            'autor' => $autor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Autor entity.
     *
     * @Route("/{id}/edit", name="autor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Autor $autor)
    {
        $deleteForm = $this->createDeleteForm($autor);
        $editForm = $this->createForm('AppBundle\Form\AutorType', $autor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!is_null($autor->getArquivoFoto())) {
                 $imagem = $autor->getArquivoFoto();

                $imagem = $this->uploader->upload($imagem);

                $autor->setFoto($imagem);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($autor);
            $em->flush();

            return $this->redirectToRoute('autor_edit', array('id' => $autor->getId()));
        }

        return $this->render('autor/edit.html.twig', array(
            'autor' => $autor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Autor entity.
     *
     * @Route("/{id}", name="autor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Autor $autor)
    {
        $form = $this->createDeleteForm($autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($autor);
            $em->flush();
        }

        return $this->redirectToRoute('autor_index');
    }

    /**
     * Creates a form to delete a Autor entity.
     *
     * @param Autor $autor The Autor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Autor $autor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('autor_delete', array('id' => $autor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
