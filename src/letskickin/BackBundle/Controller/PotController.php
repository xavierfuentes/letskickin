<?php

namespace letskickin\BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\Doctrine\PotManager;
use letskickin\BackBundle\Form\CreatePotStep3Type;

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
                $this->getPotManager()->savePot($pot);

                return $this->redirect($this->generateUrl('pot_confirm', array(
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
     * @Template("letskickinFrontBundle:Pot:confirmPot.html.twig")
     */
    public function confirmPotAction($pot_key, $admin_key = null)
    {
        $pot = $this->getPotManager()->find($pot_key, $admin_key);

        return array('pot' => $pot);
    }

	public function editPotAction(Request $request, $pot_key, $admin_key = null)
	{
		$pot = $this->getPotManager()->find($pot_key);

		$pot_form = $this->createForm(new CreatePotStep3Type(), $pot);

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

		return $this->render('letskickinFrontBundle:Pot:editPot.html.twig', array(
			'pot' 	    => $pot,
			'form'      => $pot_form->createView(),
			'isAdmin'   => $admin_mode,
		));
	}

}
