<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', 'text', [
                'label' => 'address.street',
            ])
            ->add('additional', 'text', [
                'label' => 'address.additional',
                'required' => false,
            ])
            ->add('zip_code', null, [
                'label' => 'address.zip_code',
            ])
            ->add('city', null, [
                'label' => 'address.city',
            ])
            ->add('country', 'country', [
                'label' => 'address.country',
                'preferred_choices' => ['FR', 'BE', 'LU', 'CH'],
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'AppBundle\Entity\Address',
                'translation_domain' => 'form',
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'address';
    }

}
