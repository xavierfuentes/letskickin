<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use letskickin\BackBundle\Form\ParticipantType;

class potType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        switch ($options['flowStep']) {
            case 1:
                $builder
                    ->add('admin_name', 'text')
                    ->add('admin_email', 'email')
                    ->add('occasion', 'text')
                    ->add('deadline', 'date', array(
                        'input'   => 'datetime',
                        'widget'  => 'single_text',
                        'format'  => 'dd-MM-yyyy',
                    ))
                ;
                break;
            case 2:
                $builder
//					->add('currency', 'currency')
					->add('amount_total', 'money', array(
						'required' => false,
						'precision' => 2,
//						'currency' => false,
					))
					->add('amount_partial', 'money', array(
						'required' => false,
						'precision' => 2,
//						'currency' => false,
					))
					->add('bank_account', 'text')
                ;
                break;
            case 3:
                $builder
					->add('notifications_active', 'checkbox', array(
						'required' => false
					))
					->add('participants_invite', 'checkbox', array(
						'required' => false
					))
					->add('reminders_active', 'checkbox', array(
						'required' => false
					))
                ;
                break;
            case 4:
                $builder
					->add('tracking_active', 'checkbox', array(
						'required' => false
					))
					->add('participants', 'collection', array(
						'type' => new ParticipantType(),
						'allow_add' => true,
						'allow_delete' => true,
					))
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