<?php

namespace Crmp\AccountingBundle\Form;

use Crmp\AcquisitionBundle\Form\ContractType;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

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
                'title',
                TextType::class,
                [
                    'label' => 'crmp_accounting.delivery_ticket.title',
                ]
            )
            ->add(
                'value',
                NumberType::class,
                [
                    'label' => 'crmp_accounting.delivery_ticket.total',
                ]
            )->add(
                'contract',
                null,
                [
                    'label' => 'crmp_acquisition.contract.singular',
                ]
            )->add(
                'invoice',
                null,
                [
                    'label' => 'crmp_accounting.invoice.singular',
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
                'data_class' => 'Crmp\AccountingBundle\Entity\DeliveryTicket',
            ]
        );
    }
}
