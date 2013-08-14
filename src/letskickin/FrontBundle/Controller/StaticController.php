<?php

namespace letskickin\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticController extends Controller
{
    public function landingAction()
    {
        return $this->render('letskickinFrontBundle::landing.html.twig');
    }
}
