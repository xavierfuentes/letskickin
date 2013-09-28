<?php

namespace letskickin\BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Doctrine\PotManager;
use letskickin\BackBundle\Doctrine\ParticipantManager;
use letskickin\BackBundle\Form\EditPotType;
use letskickin\BackBundle\Form\ParticipantType;

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
	 * @return ParticipantManager
	 */
	protected function getParticipantManager()
	{
		return $this->container->get('letskickin.manager.participant');
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
                $this->getPotManager()->savePot($pot);

                return $this->redirect($this->get('router')->generate('pot_confirm', array(
                    'pot_key' => $pot->getPotKey(),
                )));
            }
        }

        return array(
            'form'  => $form->createView(),
            'flow'  => $flow,
	        'pot'   => $pot,
        );
    }

    /**
     * @Template("letskickinFrontBundle:Pot:confirmPot.html.twig")
     */
    public function confirmPotAction($pot_key)
    {
        $pot = $this->getPotManager()->find($pot_key);
	    if (!$pot) {
		    throw $this->createNotFoundException();
	    }

        return array(
	        'pot' => $pot
        );
    }

	/**
	 * @Template("letskickinFrontBundle:Pot:showPot.html.twig")
	 */
	public function showPotAction(Request $request, $pot_key)
	{
		$pot = $this->getPotManager()->find($pot_key);

		if (!$pot) {
			throw $this->createNotFoundException();
		}

		$isAdmin = $pot->getAdminKey() == $request->get('admin_key') ? true : false;

		$participant = $this->getParticipantManager()->addParticipant($pot);

		$participant_form = $this->createForm(new ParticipantType(), $participant);
		$participant_form->handleRequest($request);

		if ($participant_form->isValid()) {
			$this->getParticipantManager()->saveParticipant($participant);

			return $this->redirect($this->get('router')->generate('pot_notify', array(
				'pot_key'           => $pot_key,
				'participant_key'   => $participant->getParticipantKey(),
			)));
		}

		return array(
			'pot'               => $pot,
			'participant_form'  => $participant_form->createView(),
			'isAdmin'           => $isAdmin,
		);
	}

	/**
	 * @Template("letskickinFrontBundle:Pot:notifyPot.html.twig")
	 */
	public function notifyPotAction(Request $request, $pot_key, $participant_key)
	{
		$pot = $this->getPotManager()->find($pot_key);
		if (!$pot) {
			throw $this->createNotFoundException();
		}

		$participant = $this->getParticipantManager()->find($participant_key);

		return array(
			'pot'           => $pot,
			'participant'   => $participant
		);
	}

	/**
	 * @Template("letskickinFrontBundle:Pot:blocks/headerForAdmin.html.twig")
	 */
	public function adminPotAction(Request $request, $pot_key)
	{
		$pot = $this->getPotManager()->find($pot_key);
		if (!$pot) {
			throw $this->createNotFoundException();
		}

		$pot_form = $this->createForm(new EditPotType(), $pot, array(
			'action' => $this->get('router')->generate('pot_admin', array('pot_key' => $pot_key), true),
		));

		// AJAX form submission
		if ( $request->isMethod( 'POST' ) ) {
			$pot_form->handleRequest($request);

//			$admin_key = $pot_form->get('key')->getData();

//			if ( $pot->getAdminKey() == $admin_key && $pot_form->isValid() ) {
			if ( $pot_form->isValid() ) {
				$this->getPotManager()->savePot($pot);

				$response['success'] = true;
			} else {
				$response['success'] = false;
				$response['error'] = $pot_form->getErrors();
			}

			return new JsonResponse( $response );
		}

		return array(
			'form'      => $pot_form->createView(),
			'pot'       => $pot,
		);
	}

	/**
	 * @Template("letskickinFrontBundle:Pot:blocks/participant.html.twig")
	 */
	public function adminParticipantAction(Request $request, $participant_key, $admin_key = null)
	{
		$participant = $this->getParticipantManager()->find($participant_key);
		if (!$participant) {
			throw $this->createNotFoundException();
		}

		$pot = $participant->getPot();
		$isAdmin = $pot->getAdminKey() == $admin_key ? true : false;

		$participant_form = $this->createForm(new ParticipantType(), $participant, array(
			'action' => $this->get('router')->generate('participant_admin', array('participant_key' => $participant_key), true),
		));

		// AJAX form submission
		if ( $request->isMethod( 'POST' ) ) {
			$participant_form->handleRequest($request);

			if ( $participant_form->isValid() ) {
				$this->getParticipantManager()->editParticipant($participant);

				$response['success'] = true;
			} else {
				$response['success'] = false;
				$response['error'] = $participant_form->getErrors();
			}

			return new JsonResponse( $response );
		}

		return array(
			'form'          => $participant_form->createView(),
			'participant'   => $participant,
			'isAdmin'       => $isAdmin,
		);
	}
}
