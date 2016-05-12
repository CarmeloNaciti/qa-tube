<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MediaObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mediaFile', VichFileType::class, array(
                'required'      => false,
                'allow_delete'  => false,
                'download_link' => false,
            ))
            ->add('story', TextType::class)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('tags', TextType::class)
            ->add('team', ChoiceType::class, array(
                'choices' => [
                    'Unsure' => 'Unsure',
                    'Business Development Team' => 'Business Development Team',
                    'CIC Team' => 'CIC Team',
                    'Claims Development Team' => 'Claims Development Team',
                    'Client Services Department Team' => 'Client Services Department Team',
                    'Correspondance Development Team' => 'Correspondance Development Team',
                    'Digital Client Channel Development Team' => 'Digital Client Channel Development Team',
                    'Sales Team' => 'Sales Team',
                ])
            )
            ->add('environment', ChoiceType::class, array(
                'choices' => [
                    'Web' => 'Web',
                    'Merge' => 'Merge',
                    'FAT' => 'FAT',
                    'Production' => 'Production',
                ])
            )
            ->add('type', ChoiceType::class, array(
                'choices' => [
                    'Bugfix' => 'Bugfix',
                    'Improved Feature' => 'Improved Feature',
                    'New Feature' => 'New Feature',
                    'Training' => 'Training',
                ])
            )
            ->add('user', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MediaObject',
        ]);
    }
}