<?php

namespace letskickin\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\Doctrine\GuestManager;
use letskickin\BackBundle\Doctrine\PotManager;

class PotController extends Controller
{
    /**
     * @return PotManager
     */
    protected function getPotManager()
    {
        return $this->container->get('letskickin.manager.pot');
    }

	/**
	 * @Template("letskickinFrontBundle:Pot:createPot.html.twig")
	 */
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

                return $this->redirect($this->generateUrl('pot_confirmed', array(
                    'pot_key' => $pot->getPotKey(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
            'flow' => $flow,
        );
    }

    /**
     * @Template("letskickinFrontBundle:Pot:potCreated.html.twig")
     */
    public function potConfirmedAction($pot_key, $admin_key = null)
    {
        $pot = $this->getPotManager()->find($pot_key, $admin_key);

        return array('pot' => $pot);
    }

	/**
	 * @Template("letskickinFrontBundle:Pot:showPot.html.twig")
	 */
	public function showPotAction($pot_key, $admin_key = null)
	{
		$pot = $this->getPotManager()->find($pot_key, $admin_key);

		return array('pot' => $pot);
	}

}
