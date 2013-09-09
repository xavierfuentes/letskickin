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
            'pot_form' => $form->createView(),
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
	 * @Template("letskickinFrontBundle:Pot:editPot.html.twig")
	 */
	public function editPotAction(Request $request, $pot_key, $admin_key = null)
	{
		$pot = $this->getPotManager()->find($pot_key);

		$participants_form = $this->createFormBuilder($pot)
			->add('participants', 'collection', array(
				'type' 		=> new ParticipantType(),
				'allow_add' => true,
//				'allow_delete' => true,
			))
			->add('save', 'submit')
			->getForm()
		;

		$participants_form->handleRequest($request);

		if ($participants_form->isValid()) {
			$this->getPotManager()->addParticipants($participants_form->getData()->getParticipants());
			//return $this->redirect($this->generateUrl('task_success'));
		}

		return array(
			'pot' 	=> $pot,
			'participants_form'	=> $participants_form->createView(),
		);
	}

}
