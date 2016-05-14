<?php

namespace Crmp\AcquisitionBundle\Form;

use Crmp\CrmBundle\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    const DEFAULT_TEXTAREA_HEIGHT = 20;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'crmp.acquisition.offer.title'])
            ->add('inquiry', null, ['label' => 'crmp.acquisition.inquiry.singular'])
            ->add('price', null, ['label' => 'crmp.acquisition.offer.price'])
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => 'crmp.acquisition.offer.content',
                    'trim' => true,
                    'attr' => [
                        'rows' => self::DEFAULT_TEXTAREA_HEIGHT,
                    ]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices'  => Config::getChoices('acquisition.offer.status'),
                    'expanded' => true,
                    'label' => 'crmp.acquisition.offer.status',
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
