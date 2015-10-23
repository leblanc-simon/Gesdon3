<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContributorType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                'label' => 'contributor.email',
                'required' => false,
            ])
            ->add('firstname', null, [
                'label' => 'contributor.firstname',
            ])
            ->add('lastname', null, [
                'label' => 'contributor.lastname',
            ])
            ->add('company', null, [
                'label' => 'contributor.company',
            ])
            ->add('contributor_type', null, [
                'label' => 'contributor.contributor_type',
            ])
            ->add('single_address', 'address', [
                'label' => 'contributor.single_address',
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
                'data_class' => 'AppBundle\Entity\Contributor',
                'translation_domain' => 'form',
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'contributor';
    }

}
