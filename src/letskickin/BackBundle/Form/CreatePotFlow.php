<?php

namespace letskickin\BackBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\Form\FormTypeInterface;

class CreatePotFlow extends FormFlow {

    /**
     * @var FormTypeInterface
     */
    protected $formType;

    public function setFormType(FormTypeInterface $formType) {
        $this->formType = $formType;
    }

    public function getName() {
        return 'createPot';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'data',
                'type' => $this->formType,
            ),
            array(
                'label' => 'money',
                'type' => $this->formType,
                // 'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                //     return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
                // },
            ),
            array(
                'label' => 'extra',
                'type' => $this->formType,
            ),
            array(
                'label' => 'participants',
                'type' => $this->formType, // needed to avoid InvalidOptionsException regarding option 'flowStep'
            ),
        );
    }

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);

        $options['flowStep'] = $step;

        return $options;
    }
}