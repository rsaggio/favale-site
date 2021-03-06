<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/admin", name="login")
     */
    public function loginAction()
    {
    	$authenticationUtils = $this->get('security.authentication_utils');

	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
	        'error'         => $error,
        ));
    }

 	/**
     * @Route("/admin/logout", name="logout")
     */
    public function logoutAction() {
    	
    }

}
