<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditPotType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('admin_name', 'text')
			->add('admin_email', 'email')
			->add('occasion', 'text')
			->add('deadline', 'date', array(
				'input'   => 'datetime',
				'widget'  => 'single_text',
				'format'  => 'dd-MM-yyyy',
			))
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
			->add('save', 'button')
		;
	}

	public function getName() {
		return 'createPotStep3Type';
	}

}