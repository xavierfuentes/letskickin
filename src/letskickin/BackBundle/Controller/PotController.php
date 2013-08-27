<?php

namespace letskickin\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use letskickin\BackBundle\Entity\Pot;

class PotController extends Controller
{
    public function createPotAction()
    {
        $pot = new Pot();

        $flow = $this->get('letskickin.form.flow.createPot');
        $flow->bind($pot);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();
                $em->persist($pot);
                $em->flush();

                // use this when a guest is added
                // logic to add a guest
                // $dispatcher = $this->container->get('event_dispatcher');
                // $dispatcher->dispatch('letskickin.pot.guest_added', new GuestEvent($pot, $guest));

                return $this->redirect($this->generateUrl('home'));
            }
        }

        return $this->render('letskickinFrontBundle:Pot:createPot.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
}
