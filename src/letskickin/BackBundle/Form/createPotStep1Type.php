<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreatePotStep1Type extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('admin_name', 'text')
			->add('admin_email', 'email')
			->add('occasion', 'text')
			->add('deadline', 'date', array(
				'widget'  => 'text',
				'format'  => 'dd/MM/yyyy',
			))
		;
	}

	public function getName() {
		return 'CreatePotStep1Type';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'translation_domain' => 'pot'
		));
	}
}
