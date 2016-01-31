<?php

namespace Crmp\AcquisitionBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
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
            ->add('title')
            ->add('customer')
            ->add(
                'inquiredAt',
                \Symfony\Component\Form\Extension\Core\Type\DateType::class,
                [
	                'label' => 'Date',
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
                    'label' => 'Predicted value',
                ]
            )
            ->add('content');
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
