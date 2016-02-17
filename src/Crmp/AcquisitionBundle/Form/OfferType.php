<?php

namespace Crmp\AcquisitionBundle\Form;

use Crmp\CrmBundle\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('inquiry')
            ->add('price')
            ->add('content')
            ->add(
                'status',
                ChoiceType::class, [
                    'choices'  => Config::getChoices('acquisition.offer.status'),
                    'expanded' => true,
                ]
            );
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crmp\AcquisitionBundle\Entity\Offer'
        ));
    }
}
