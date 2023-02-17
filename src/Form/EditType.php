<?php

namespace App\Form;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('plainPassword', PasswordType::class, [
                'required' => false,
                'label' => "Password",
            ])
            ->add('image', HiddenType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'image-id',
                ],
            ])
            ->add('edit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => User::class,
            ]);
    }
    
}