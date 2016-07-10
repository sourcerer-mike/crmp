<?php

namespace Crmp\AcquisitionBundle\Form;

use Crmp\CrmBundle\Entity\Config;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InquiryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'crmp_acquisition.inquiry.title'])
            ->add('customer', null, ['label' => 'crmp_crm.customer.singular'])
            ->add(
                'inquiredAt',
                \Symfony\Component\Form\Extension\Core\Type\DateType::class,
                [
                    'label' => 'crmp_acquisition.inquiry.date',
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'attr'   => [
                        'class'            => 'form-control input-inline datepicker',
                        'data-provide'     => 'datepicker',
                        'data-date-format' => 'dd.mm.yyyy',
                    ],
                ]
            )
            ->add(
                'netValue',
                null,
                [
                    'label' => 'crmp_acquisition.inquiry.predictedValue',
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices' => Config::getChoices('acquisition.inquiry.status'),
                    'expanded' => true,
                    'label' => 'crmp_acquisition.inquiry.statusLabel',
                ]
            )
            ->add('content', null, ['label' => 'crmp_acquisition.inquiry.content']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Crmp\AcquisitionBundle\Entity\Inquiry',
            )
        );
    }
}
