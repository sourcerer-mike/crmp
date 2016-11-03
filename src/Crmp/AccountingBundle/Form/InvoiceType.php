<?php

namespace Crmp\AccountingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

/**
 * Form for invoices.
 *
 * @package Crmp\AccountingBundle\Form
 */
class InvoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', null, ['label' => 'crmp_crm.customer.singular'])
            ->add(
                'value',
                NumberType::class,
                [
                    'label'       => 'crmp_accounting.invoice.total',
                    'attr'        => [
                        'min' => 0,
                    ],
                    'constraints' => [
                        new GreaterThan(0),
                    ],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Crmp\AccountingBundle\Entity\Invoice',
            )
        );
    }
}
