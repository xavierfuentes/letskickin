<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreatePotStep1Type extends AbstractType {

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
		;
	}

	public function getName() {
		return 'createPotStep1Type';
	}
}