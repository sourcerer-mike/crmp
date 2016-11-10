<?php

namespace Crmp\AccountingBundle\Form;

use Crmp\AccountingBundle\Entity\DeliveryTicket;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Form\ContractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form for deliveryTickets.
 *
 * @package Crmp\AccountingBundle\Form
 */
class DeliveryTicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'invoice',
                EntityType::class,
                [
                    'class'        => Invoice::class,
                    'choice_label' => 'customer',
                    'choice_value' => 'id',
                    'label'        => 'crmp_accounting.invoice.singular',
                    'placeholder'  => 'crmp.pleaseChoose',
                    'disabled'     => true,
                ]
            )->add(
                'title',
                TextType::class,
                [
                    'label'    => 'crmp_accounting.delivery_ticket.title',
                    'required' => true,
                ]
            )
            ->add(
                'value',
                NumberType::class,
                [
                    'label'    => 'crmp_accounting.delivery_ticket.total',
                    'required' => true,
                ]
            )->add(
                'contract',
                EntityType::class,
                [
                    'class'        => Contract::class,
                    'choice_label' => 'title',
                    'choice_value' => 'id',
                    'label'        => 'crmp_acquisition.contract.singular',
                    'placeholder'  => 'crmp.pleaseChoose',
                    'required'     => true,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => DeliveryTicket::class,
            ]
        );
    }
}
