<?php

namespace Crmp\CrmBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'crmp.crm.address.name'])
            ->add(
                'customer',
                null,
                [
                    'label'        => 'crmp.crm.customer.singular',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ]
            )
            ->add('mail', null, ['label' => 'crmp.crm.address.mail']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Crmp\CrmBundle\Entity\Address',
            )
        );
    }
}
