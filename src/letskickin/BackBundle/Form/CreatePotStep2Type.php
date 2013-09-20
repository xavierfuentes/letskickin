<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreatePotStep2Type extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
//			->add('currency', 'currency')
			->add('amount_total', 'money', array(
				'required' => false,
				'precision' => 2,
//					'currency' => false,
			))
			->add('amount_partial', 'money', array(
				'required' => false,
				'precision' => 2,
//					'currency' => false,
			))
			->add('bank_account', 'text')
		;
	}

	public function getName() {
		return 'CreatePotStep2Type';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'translation_domain' => 'pot'
		));
	}

}