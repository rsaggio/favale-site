<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BannerPrincipal;
use AppBundle\Form\BannerPrincipalType;
use AppBundle\Services\UploadService;

/**
 * BannerPrincipal controller.
 *
 * @Route("/admin/banner", service="banner_controller")
 */
class BannerPrincipalController extends Controller
{
    private $uploader;

    public function __construct($container,UploadService $uploader) {
        $this->container = $container;
        $this->uploader = $uploader;
    }
    /**
     * Lists all BannerPrincipal entities.
     *
     * @Route("/", name="bannerprincipal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bannerPrincipals = $em->getRepository('AppBundle:BannerPrincipal')->findAll();

        return $this->render('bannerprincipal/index.html.twig', array(
            'bannerPrincipals' => $bannerPrincipals,
        ));
    }

    /**
     * Creates a new BannerPrincipal entity.
     *
     * @Route("/new", name="bannerprincipal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bannerPrincipal = new BannerPrincipal();
        $form = $this->createForm('AppBundle\Form\BannerPrincipalType', $bannerPrincipal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $bannerPrincipal->getArquivoFoto();

            $image = $this->uploader->upload($image);

            $bannerPrincipal->setFoto($image);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bannerPrincipal);
            $em->flush();

            return $this->redirectToRoute('bannerprincipal_show', array('id' => $bannerPrincipal->getId()));
        }

        return $this->render('bannerprincipal/new.html.twig', array(
            'bannerPrincipal' => $bannerPrincipal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BannerPrincipal entity.
     *
     * @Route("/{id}", name="bannerprincipal_show")
     * @Method("GET")
     */
    public function showAction(BannerPrincipal $bannerPrincipal)
    {
        $deleteForm = $this->createDeleteForm($bannerPrincipal);

        return $this->render('bannerprincipal/show.html.twig', array(
            'bannerPrincipal' => $bannerPrincipal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BannerPrincipal entity.
     *
     * @Route("/{id}/edit", name="bannerprincipal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BannerPrincipal $bannerPrincipal)
    {
        $deleteForm = $this->createDeleteForm($bannerPrincipal);
        $editForm = $this->createForm('AppBundle\Form\BannerPrincipalType', $bannerPrincipal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!is_null($bannerPrincipal->getArquivoFoto())) {
                $image = $bannerPrincipal->getArquivoFoto();

                 $image = $this->uploader->upload($image);

                $bannerPrincipal->setFoto($image);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($bannerPrincipal);
            $em->flush();

            return $this->redirectToRoute('bannerprincipal_edit', array('id' => $bannerPrincipal->getId()));
        }

        return $this->render('bannerprincipal/edit.html.twig', array(
            'bannerPrincipal' => $bannerPrincipal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BannerPrincipal entity.
     *
     * @Route("/{id}", name="bannerprincipal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BannerPrincipal $bannerPrincipal)
    {
        $form = $this->createDeleteForm($bannerPrincipal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bannerPrincipal);
            $em->flush();
        }

        return $this->redirectToRoute('bannerprincipal_index');
    }

    /**
     * Creates a form to delete a BannerPrincipal entity.
     *
     * @param BannerPrincipal $bannerPrincipal The BannerPrincipal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BannerPrincipal $bannerPrincipal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bannerprincipal_delete', array('id' => $bannerPrincipal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
