<?php

namespace letskickin\BackBundle\Controller;

use letskickin\BackBundle\Event\GuestEvent;
use letskickin\BackBundle\Event\PotEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\Doctrine\GuestManager;
use letskickin\BackBundle\Doctrine\PotManager;

class PotController extends Controller
{
    public function createPotAction()
    {
        $pot = $this->getPotManager()->createPot();

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

                $this->getPotManager()->savePot($pot);

                return $this->redirect($this->generateUrl('pot_created'));
            }
        }

        return $this->render('letskickinFrontBundle:Pot:createPot.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }

    public function addGuestAction(Request $request, Pot $pot_id)
    {
        $em = $this->getDoctrine()->getManager();

        $pot = $this->getPotManager()->find($pot_id);
        $guest = $this->getGuestManager()->createGuest();
        $guest->setPot($pot);

        $form = $this->createForm(new GuestType(), $guest);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getGuestManager()->saveGuest($pot, $guest);

                return $this->redirect($this->generateUrl('home'));
            }
        }

        return $this->render('FooVendorBundle:Post:addComment.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return PotManager
     */
    protected function getPotManager()
    {
        return $this->container->get('letskickin.manager.pot');
    }

    /**
     * @return GuestManager
     */
    protected function getGuestManager()
    {
        return $this->container->get('letskickin.manager.guest');
    }
}
