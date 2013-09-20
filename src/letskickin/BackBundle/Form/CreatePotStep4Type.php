<?php

namespace letskickin\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreatePotStep4Type extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
//			->add('tracking_active', 'checkbox', array(
//				'required' => false
//			))
//			->add('guests', 'collection', array(
//				'type' => new GuestType(),
//				'by_reference' => false,
//				'allow_add' => true,
//				'allow_delete' => true,
//			))
		;
	}

	public function getName() {
		return 'CreatePotStep4Type';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'translation_domain' => 'pot'
		));
	}

}