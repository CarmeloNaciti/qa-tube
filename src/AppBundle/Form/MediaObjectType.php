<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This file is part of the MiWay Insurance Application.
 *
 * @author      MiWay Development Team
 * @copyright   Copyright (c) 2014-2016 MiWay Insurance Ltd
 */
class MediaObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('tags', TextType::class)
            ->add('team', TextType::class)
            ->add('environment', TextType::class)
            ->add('story', TextType::class)
            ->add('type', TextType::class)
            ->add('user', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MediaObject',
        ]);
    }
}