<?php

namespace App\Form;
use App\Entity\Chat;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your chat name...',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your chat description...',
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Chat::class,
            ]);
    }
}