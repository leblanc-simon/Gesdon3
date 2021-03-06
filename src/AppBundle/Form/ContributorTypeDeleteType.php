<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContributorTypeDeleteType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('submit', 'submit', [
                'label' => 'button.delete',
                'attr' => [
                    'class' => 'btn-danger',
                ]
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
                'data_class' => 'AppBundle\Entity\ContributorType',
                'translation_domain' => 'form',
                'label' => false,
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'contributor_type_delete';
    }

}
