<?php

namespace Application\Letskickin\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Application\Letskickin\CoreBundle\Entity\Participant;

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
	        ->add('amount', 'money', array(
		        'required' => false,
		        'precision' => 2,
//				'currency' => false,
	        ))
            ->add('status', 'hidden')
	        ->add('save', 'submit')
            ->add('cannot', 'button')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Letskickin\CoreBundle\Entity\Participant',
	        'translation_domain' => 'pot',
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
