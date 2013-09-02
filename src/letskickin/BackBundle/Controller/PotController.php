<?php

namespace letskickin\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\Doctrine\PotManager;
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

	/**
	 * @Template("letskickinFrontBundle:Pot:showPot.html.twig")
	 */
	public function showPotAction(Request $request, $pot_key, $admin_key = null)
	{
		$pot = $this->getPotManager()->find($pot_key, $admin_key);

		$form = $this->createFormBuilder($pot)
			->add('participants', 'collection', array(
				'type' 		=> new ParticipantType(),
				'allow_add' => true,
				'allow_delete' => true,
			))
			->add('save', 'submit')
			->getForm()
		;

		$form->handleRequest($request);

		$this->getPotManager()->addParticipants($form->getData()->getParticipants());

		if ($form->isValid()) {

			//return $this->redirect($this->generateUrl('task_success'));
		}

		return array(
			'pot' 	=> $pot,
			'participants_form'	=> $form->createView(),
		);
	}

}
