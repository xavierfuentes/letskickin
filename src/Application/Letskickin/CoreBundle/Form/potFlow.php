<?php

namespace Application\Letskickin\CoreBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;

class PotFlow extends FormFlow {

    public function getName() {
        return 'createPot';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'data',
                'type' => new CreatePotStepDataType(),
            ),
            array(
                'label' => 'money',
                'type' => new CreatePotStepMoneyType(),
            ),
            array(
                'label' => 'extra',
//                'type' => new CreatePotStepExtraType(),
            ),
            array(
                'label' => 'guests',
                'type' => new CreatePotStepGuestsType(),
            ),
        );
    }
}