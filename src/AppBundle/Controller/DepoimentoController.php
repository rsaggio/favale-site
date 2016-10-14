<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Depoimento;
use AppBundle\Form\DepoimentoType;
use AppBundle\Services\UploadService;

/**
 * Depoimento controller.
 *
 * @Route("/admin/depoimento", service="depoimento_controller")
 */
class DepoimentoController extends Controller
{

    private $uploader;

    public function __construct($container, UploadService $uploader) {
        $this->container = $container;
        $this->uploader = $uploader;
    }
    /**
     * Lists all Depoimento entities.
     *
     * @Route("/", name="admin_depoimento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $depoimentos = $em->getRepository('AppBundle:Depoimento')->findAll();

        return $this->render('depoimento/index.html.twig', array(
            'depoimentos' => $depoimentos,
        ));
    }

    /**
     * Creates a new Depoimento entity.
     *
     * @Route("/new", name="admin_depoimento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $depoimento = new Depoimento();
        $form = $this->createForm('AppBundle\Form\DepoimentoType', $depoimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imagem = $depoimento->getArquivoFoto();

            $imagem = $this->uploader->upload($imagem);

            $depoimento->setFoto($imagem);

            $em = $this->getDoctrine()->getManager();
            $em->persist($depoimento);
            $em->flush();

            return $this->redirectToRoute('admin_depoimento_show', array('id' => $depoimento->getId()));
        }

        return $this->render('depoimento/new.html.twig', array(
            'depoimento' => $depoimento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Depoimento entity.
     *
     * @Route("/{id}", name="admin_depoimento_show")
     * @Method("GET")
     */
    public function showAction(Depoimento $depoimento)
    {
        $deleteForm = $this->createDeleteForm($depoimento);

        return $this->render('depoimento/show.html.twig', array(
            'depoimento' => $depoimento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Depoimento entity.
     *
     * @Route("/{id}/edit", name="admin_depoimento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Depoimento $depoimento)
    {
        $deleteForm = $this->createDeleteForm($depoimento);
        $editForm = $this->createForm('AppBundle\Form\DepoimentoType', $depoimento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!is_null($depoimento->getArquivoFoto())) {
                 $imagem = $depoimento->getArquivoFoto();

                $imagem = $this->uploader->upload($imagem);

                $depoimento->setFoto($imagem);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($depoimento);
            $em->flush();

            return $this->redirectToRoute('admin_depoimento_edit', array('id' => $depoimento->getId()));
        }

        return $this->render('depoimento/edit.html.twig', array(
            'depoimento' => $depoimento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Depoimento entity.
     *
     * @Route("/{id}", name="admin_depoimento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Depoimento $depoimento)
    {
        $form = $this->createDeleteForm($depoimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($depoimento);
            $em->flush();
        }

        return $this->redirectToRoute('admin_depoimento_index');
    }

    /**
     * Creates a form to delete a Depoimento entity.
     *
     * @param Depoimento $depoimento The Depoimento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Depoimento $depoimento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_depoimento_delete', array('id' => $depoimento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
