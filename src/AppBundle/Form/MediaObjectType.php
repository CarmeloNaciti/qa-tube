<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MediaObjectType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    protected $containerInterface;

    protected $security_context;

    /**
     * @inheritdoc
     */
    public function __construct(ContainerInterface $containerInterface, TokenStorage $security_context)
    {
        $this->containerInterface = $containerInterface;
        $this->security_context = $security_context;
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
                'attr' => [
                    'accept' => 'video/*'
                ]
            ))
            ->add('story', TextType::class)
            ->add('isSignOff', CheckboxType::class, [
                'required' => false,
            ])
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('tags', TextType::class)
            ->add('team', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('teams')))
            ->add('environment', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('environments')))
            ->add('type', ChoiceType::class, array('choices' => $this->containerInterface->getParameter('issue_type')))
            ->add('user', TextType::class, array(
                'data' => $this->security_context->getToken()->getUser(),
                'attr' => [
                    'readonly' => 'readonly',
                ]
            ));
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