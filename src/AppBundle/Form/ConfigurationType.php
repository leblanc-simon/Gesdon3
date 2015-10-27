<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('configurations', 'collection', [
                'type' => 'configuration_item',
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
        $resolver
            ->setDefaults([
                'translation_domain' => 'form',
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'configuration';
    }
}