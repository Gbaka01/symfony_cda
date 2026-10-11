<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d\'indiquer votre nom.'),
                    new Assert\Length(max: 100),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d\'indiquer votre email.'),
                    new Assert\Email(message: 'Cet email n\'est pas valide.'),
                ],
            ])
            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(max: 150),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => 6],
                'constraints' => [
                    new Assert\NotBlank(message: 'Le message ne peut pas être vide.'),
                    new Assert\Length(min: 10, max: 5000,
                        minMessage: 'Votre message doit faire au moins {{ limit }} caractères.'),
                ],
            ])
            // Champ piège anti-spam : invisible pour les humains, rempli par les robots
            ->add('website', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => false,
                'attr' => ['autocomplete' => 'off', 'tabindex' => '-1'],
                'row_attr' => ['style' => 'position:absolute;left:-9999px;', 'aria-hidden' => 'true'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_token_id' => 'contact',
        ]);
    }
}
