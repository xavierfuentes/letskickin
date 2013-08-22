<?php

namespace letskickin\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use letskickin\BackBundle\Entity\Pot;

class PotController extends Controller
{
    public function createPotAction()
    {
        $formData = new Pot(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->get('letskickin.form.flow.createPot'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($formData);
                $em->flush();

                return $this->redirect($this->generateUrl('home')); // redirect when done
            }
        }

        return $this->render('letskickinFrontBundle:Pot:createPot.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
}
