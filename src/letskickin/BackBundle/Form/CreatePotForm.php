<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreatePotForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        switch ($options['flowStep']) {
            case 1:
                $builder->add('pot_key', 'hidden')
                        ->add('admin_key', 'hidden')
                        ->add('admin_name', 'text')
                        ->add('admin_email', 'text')
                        ->add('occasion', 'text')
                        ->add('deadline', 'date', array(
                            'input'   => 'datetime',
                            'widget'  => 'single_text',
                            'format'  => 'dd-MM-yyyy',
                        ))
                ;
                break;
            case 2:
                $currencies = array("EUR", "USD");
                $builder->add('currency', 'choice', array(
                            'choices' => array_combine($currencies, $currencies),
                            'empty_value' => '',
                        ))
                        ->add('amount_total', 'text', array(
                            //'precision' => 2,
                            //'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFDOWN
                        ))
                        ->add('amount_partial', 'text', array(
                            'required' => false
                            //'precision' => 2,
                            //'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFDOWN
                        ))
                        ->add('bank_account', 'text')
                ;
                break;
            case 3:
                $builder->add('notifications_active', 'checkbox', array(
                            'required' => false
                        ))
                        ->add('guests_invite', 'checkbox', array(
                            'required' => false
                        ))
                        ->add('reminders_active', 'checkbox', array(
                            'required' => false
                        ))
                ;
                break;
            case 4:
                $builder->add('tracking_active', 'checkbox', array(
                            'required' => false
                        ))
//                        ->add('guests', 'collection', array(
//                            'type' => new CreateGuestForm(),
//                            'required' => false,
//                            'allow_add' => true,
//                        ))
                ;
                break;
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'flowStep' => null,
            'data_class' => 'letskickin\BackBundle\Entity\Pot',
        ));
    }

    public function getName() {
        return 'createPot';
    }
}