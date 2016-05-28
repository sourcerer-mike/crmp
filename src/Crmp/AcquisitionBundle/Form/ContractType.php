<?php

namespace Crmp\AcquisitionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'crmp_acquisition.contract.title'])
            ->add('offer', null, ['label' => 'crmp_acquisition.offer.singular'])
            ->add('value', null, ['label' => 'crmp_acquisition.contract.value'])
            ->add('content', null, ['label' => 'crmp_acquisition.contract.content']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Crmp\AcquisitionBundle\Entity\Contract',
            )
        );
    }
}
