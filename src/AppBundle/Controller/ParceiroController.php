<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Parceiro;
use AppBundle\Form\ParceiroType;
use AppBundle\Services\UploadService;

/**
 * Parceiro controller.
 *
 * @Route("/admin/parceiro", service="parceiro_controller")
 */
class ParceiroController extends Controller
{

    private $uploader;

    public function __construct($container,UploadService $uploader) {
        $this->container = $container;
        $this->uploader = $uploader;
    }
    /**
     * Lists all Parceiro entities.
     *
     * @Route("/", name="admin_parceiro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parceiros = $em->getRepository('AppBundle:Parceiro')->findAll();

        return $this->render('parceiro/index.html.twig', array(
            'parceiros' => $parceiros,
        ));
    }

    /**
     * Creates a new Parceiro entity.
     *
     * @Route("/new", name="admin_parceiro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $parceiro = new Parceiro();
        $form = $this->createForm('AppBundle\Form\ParceiroType', $parceiro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $parceiro->getImagemArquivo();

            $image = $this->uploader->upload($image);

            $parceiro->setImagem($image);

            $em = $this->getDoctrine()->getManager();
            $em->persist($parceiro);
            $em->flush();

            return $this->redirectToRoute('admin_parceiro_show', array('id' => $parceiro->getId()));
        }

        return $this->render('parceiro/new.html.twig', array(
            'parceiro' => $parceiro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Parceiro entity.
     *
     * @Route("/{id}", name="admin_parceiro_show")
     * @Method("GET")
     */
    public function showAction(Parceiro $parceiro)
    {
        $deleteForm = $this->createDeleteForm($parceiro);

        return $this->render('parceiro/show.html.twig', array(
            'parceiro' => $parceiro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Parceiro entity.
     *
     * @Route("/{id}/edit", name="admin_parceiro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Parceiro $parceiro)
    {
        $deleteForm = $this->createDeleteForm($parceiro);
        $editForm = $this->createForm('AppBundle\Form\ParceiroType', $parceiro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!is_null($parceiro->getImagemArquivo())) {

                $image = $parceiro->getImagemArquivo();

                $image = $this->uploader->upload($image);

                $parceiro->setImagem($image);
                
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($parceiro);
            $em->flush();

            return $this->redirectToRoute('admin_parceiro_edit', array('id' => $parceiro->getId()));
        }

        return $this->render('parceiro/edit.html.twig', array(
            'parceiro' => $parceiro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Parceiro entity.
     *
     * @Route("/{id}", name="admin_parceiro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Parceiro $parceiro)
    {
        $form = $this->createDeleteForm($parceiro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parceiro);
            $em->flush();
        }

        return $this->redirectToRoute('admin_parceiro_index');
    }

    /**
     * Creates a form to delete a Parceiro entity.
     *
     * @param Parceiro $parceiro The Parceiro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Parceiro $parceiro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_parceiro_delete', array('id' => $parceiro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
