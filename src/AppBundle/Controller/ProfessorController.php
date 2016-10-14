<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Professor;
use AppBundle\Form\ProfessorType;
use AppBundle\Services\UploadService;

/**
 * Professor controller.
 *
 * @Route("/admin/professor", service="professor_controller")
 */
class ProfessorController extends Controller
{

    private $uploader;

    public function __construct($container, UploadService $uploader) {
        $this->uploader = $uploader;
        $this->container = $container;
    }
    /**
     * Lists all Professor entities.
     *
     * @Route("/", name="professor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $professors = $em->getRepository('AppBundle:Professor')->findAll();

        return $this->render('professor/index.html.twig', array(
            'professors' => $professors,
        ));
    }

    /**
     * Creates a new Professor entity.
     *
     * @Route("/new", name="professor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $professor = new Professor();
        $form = $this->createForm('AppBundle\Form\ProfessorType', $professor);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $image = $professor->getArquivoFoto();

            $image = $this->uploader->upload($image);

            $professor->setFoto($image);

            $em = $this->getDoctrine()->getManager();
            $em->persist($professor);
            $em->flush();

            return $this->redirectToRoute('professor_show', array('id' => $professor->getId()));
        }

        return $this->render('professor/new.html.twig', array(
            'professor' => $professor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Professor entity.
     *
     * @Route("/{id}", name="professor_show")
     * @Method("GET")
     */
    public function showAction(Professor $professor)
    {
        $deleteForm = $this->createDeleteForm($professor);

        return $this->render('professor/show.html.twig', array(
            'professor' => $professor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Professor entity.
     *
     * @Route("/{id}/edit", name="professor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Professor $professor)
    {
        $deleteForm = $this->createDeleteForm($professor);
        $editForm = $this->createForm('AppBundle\Form\ProfessorType', $professor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!is_null($professor->getArquivoFoto())) {
                $image = $professor->getArquivoFoto();

                $image = $this->uploader->upload($image);

                $professor->setFoto($image);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($professor);
            $em->flush();

            return $this->redirectToRoute('professor_edit', array('id' => $professor->getId()));
        }

        return $this->render('professor/edit.html.twig', array(
            'professor' => $professor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Professor entity.
     *
     * @Route("/{id}", name="professor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Professor $professor)
    {
        $form = $this->createDeleteForm($professor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($professor);
            $em->flush();
        }

        return $this->redirectToRoute('professor_index');
    }

    /**
     * Creates a form to delete a Professor entity.
     *
     * @param Professor $professor The Professor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Professor $professor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('professor_delete', array('id' => $professor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
