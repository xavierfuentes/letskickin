<?php

namespace letskickin\BackBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;

class PotFlow extends FormFlow {

    public function getName() {
        return 'createPot';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'data',
                'type' => new CreatePotStep1Type(),
            ),
            array(
                'label' => 'money',
                'type' => new CreatePotStep2Type(),
            ),
            array(
                'label' => 'extra',
                'type' => new CreatePotStep3Type(),
            ),
            array(
                'label' => 'guests',
                'type' => new CreatePotStep4Type(),
            ),
        );
    }
}