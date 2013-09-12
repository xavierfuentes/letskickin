<?php

namespace letskickin\BackBundle\Controller;

use letskickin\BackBundle\Form\ParticipantType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Doctrine\PotManager;
use letskickin\BackBundle\Doctrine\ParticipantManager;
use letskickin\BackBundle\Form\EditPotType;

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

                return $this->redirect($this->generateUrl('pot_confirm', array(
                    'pot_key' => $pot->getPotKey(),
                )));
            }
        }

        return array(
            'form'  => $form->createView(),
            'flow'  => $flow,
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
			if ($participant_form->get('cannot')->isClicked()) {
				$this->getParticipantManager()->notParticipant($participant);
			}

			$this->getParticipantManager()->saveParticipant($participant);

			return $this->redirect($this->generateUrl('pot_notify', array(
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
	 * @Template("letskickinFrontBundle:Pot:adminPot.html.twig")
	 */
	public function adminPotAction(Request $request, $pot_key, $admin_key)
	{
		$pot = $this->getPotManager()->find($pot_key);
		if (!$pot) {
			throw $this->createNotFoundException();
		}

		$pot_form = $this->createForm(new EditPotType(), $pot);

		// AJAX form submission
		if ( $request->isMethod( 'POST' ) ) {
			$pot_form->handleRequest($request);

			if ( $pot_form->isValid( ) ) {
				$this->getPotManager()->updatePot($pot);

				$response['success'] = true;
			} else {
				$response['success'] = false;
				$response['error'] = $pot_form->getErrors();
			}

			return new JsonResponse( $response );
		}

		$admin_mode = $pot->getAdminKey() ==  $admin_key ? true : false;

		return $this->render('letskickinFrontBundle:Pot:adminPot.html.twig', array(
			'pot'               => $pot,
			'pot_form'          => $pot_form->createView(),
			'isAdmin'           => $admin_mode,
			'participant_form'  => $participant_form,
		));
	}
}
