<?php

namespace letskickin\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaticController extends Controller
{
	public function landingAction()
    {
		return $this->render('letskickinFrontBundle:Static:landing.html.twig');
    }
}
