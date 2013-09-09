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
                'type' => new createPotStep1Type(),
            ),
            array(
                'label' => 'money',
                'type' => new createPotStep2Type(),
            ),
            array(
                'label' => 'extra',
                'type' => new createPotStep3Type(),
            ),
            array(
                'label' => 'participants',
                'type' => new createPotStep4Type(),
            ),
        );
    }
}