<?php

namespace App\Form;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('text', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => 'Type your message...',
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolser)
    {
        $resolser
            ->setDefaults([
                'data_class' => Message::class,
                'attr' => [
                    'class' => 'chat-form',
                ],
            ])
        ;
    }
}