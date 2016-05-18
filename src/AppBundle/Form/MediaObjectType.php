<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MediaObjectType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    protected $containerInterface;

    /**
     * @inheritdoc
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    /**
     * @inheritdoc
     */
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
            ->add('team', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('teams')))
            ->add('environment', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('environments')))
            ->add('type', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('issue_type')))
            ->add('user', TextType::class);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MediaObject',
        ]);
    }
}