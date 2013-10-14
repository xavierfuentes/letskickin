<?php

namespace Application\Letskickin\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditPotType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('key', 'hidden', array(
				'mapped'  => false
			))
			->add('admin_name', 'text')
			->add('admin_email', 'email')
//			->add('occasion', 'text')
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
			->add('save', 'submit')
		;
	}

	public function getName() {
		return 'editPotType';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'translation_domain' => 'pot'
		));
	}

}