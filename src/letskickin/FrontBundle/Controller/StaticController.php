<?php

namespace letskickin\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticController extends Controller
{
    public function indexAction()
    {
        return $this->render('letskickinFrontBundle:Static:index.html.twig');
    }
}
