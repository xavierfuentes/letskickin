<?php

namespace letskickin\BackBundle\Form;

use letskickin\BackBundle\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParticipantType extends AbstractType
{
	private $pot;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
			->add('concept', 'text')
			->add('status', 'checkbox', array(
				'required' => false,
			))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'letskickin\BackBundle\Entity\Participant',
			/*'empty_data' => function (FormInterface $form) {
				return new Participant(
					$form->getData()['pot']
				);
			},*/
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'createParticipant';
    }
}
