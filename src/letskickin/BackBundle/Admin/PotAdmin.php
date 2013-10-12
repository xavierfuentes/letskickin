<?php

namespace letskickin\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use letskickin\BackBundle\Form\ParticipantType;

class PotAdmin extends Admin
{
    /**
     * Fields to be shown on filter forms
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('status')
            ->add('occasion')
            ->add('admin_email')
            ->add('creation_date')
            ->add('deadline')
            ->add('currency')
            ->add('amount_total')
            ->add('amount_partial')
            ->add('collection_method')
        ;
    }

    /**
     * Fields to be shown on lists
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('status')
            ->add('creation_date')
            ->add('last_edition_date')
            ->add('occasion')
            ->add('admin_name')
            ->add('admin_email')
            ->add('deadline')
            ->add('currency')
            ->add('amount_total')
            ->add('amount_partial')
            ->add('collection_method')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * Fields to be shown on create/edit forms
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('status')
            ->add('creation_date', 'datetime', array(
                'widget'  => 'text',
                'format'  => 'dd/MM/yyyy HH:ii',
            ))
            ->add('last_edition_date', 'datetime', array(
                'required' => false,
                'widget'  => 'text',
                'format'  => 'dd/MM/yyyy HH:ii',
            ))
            ->add('admin_name', 'text')
            ->add('admin_email', 'email')
            ->add('occasion', 'text')
            ->add('deadline', 'date', array(
                'widget'  => 'text',
                'format'  => 'dd/MM/yyyy',
            ))
            ->add('amount_total', 'money', array(
                'required' => false,
                'precision' => 2,
            ))
            ->add('amount_partial', 'money', array(
                'required' => false,
                'precision' => 2,
            ))
            ->add('bank_account', 'text')
        ;
    }

    /**
     * Fields to be shown on the entity
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('status')
            ->add('creation_date')
            ->add('last_edition_date')
            ->add('pot_key')
            ->add('occasion')
            ->add('admin_key')
            ->add('admin_name')
            ->add('admin_email')
            ->add('deadline')
            ->add('currency')
            ->add('amount_total')
            ->add('amount_partial')
            ->add('bank_account')
            ->add('collection_method')
        ;
    }
}
