<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', 'text', [
                'label' => 'contributor_type.slug',
            ])
            ->add('name', 'text', [
                'label' => 'contributor_type.name',
            ])
            ->add('submit', 'submit', [
                'label' => 'button.save',
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\PaymentType',
            'translation_domain' => 'form',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'payment_type';
    }
}