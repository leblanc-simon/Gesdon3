<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contributor', 'contributor', [
                'label' => 'donation.contributor',
            ])
            ->add('uuid', null, [
                'label' => 'donation.uuid',
            ])
            ->add('payment_type', null, [
                'label' => 'donation.payment_type',
            ])
            ->add('amount', 'money', [
                'label' => 'donation.amount',
            ])
            ->add('via', null, [
                'label' => 'donation.via',
            ])
            ->add('fee', 'money', [
                'label' => 'donation.fee',
            ])
            ->add('created_at', 'date', [
                'label' => 'donation.created_at',
                'widget' => 'single_text',
            ])
            ->add('submit', 'submit', [
                'label' => 'button.save'
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
                'data_class' => 'AppBundle\Entity\Donation',
                'translation_domain' => 'form',
                'label' => 'donation.title',
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'donation';
    }

}
