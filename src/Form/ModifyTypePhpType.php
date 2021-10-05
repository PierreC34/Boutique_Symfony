<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModifyTypePhpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("nom",TextType::class,[
            "label"=>"Nom",
            'constraints'=>new Length(null,2,30),
            "attr"=>[
                "placeholder"=>"Ajouter votre nom"
            ],
            "disabled"=>true

        ])
        ->add("prenom",TextType::class,[
            "label"=>"Prénom",
            'constraints'=>new Length(null,2,30),
            "attr"=>[
                "placeholder"=>"Ajouter votre prenom"
            ],
            "disabled"=>true
        ])
        ->add("ville",TextType::class,[
            "label"=>"Ville",
            "attr"=>[
                "placeholder"=>"Ville"
            ],
        ])
        ->add("email",EmailType::class,[
            "label" => "Votre E-mail",
            "constraints"=>new NotBlank([
                'message'=>"Ce champ doit etre remplis"]),
            "attr"=>[
                'placeholder'=> "Saisir votre E-mail"
            ],
            "disabled"=>true
        ])
        ->add("old_password",PasswordType::class,[
            "label"=>"Votre ancien mot de passe",
            "invalid_message"=>"Rentrez votre ancien mot de passe",
            "mapped"=> false,
            ])

        ->add("new_password",RepeatedType::class,[
            "type"=>PasswordType::class,
            "invalid_message"=>"Rentrez votre nouveau mot de passe",
            "mapped"=> false,
            "first_options"=>[
                "label"=>"Votre nouveau mot de passe",
                "attr"=>[
                    "placeholder"=>"Merci de saisir votre mot de passe"
                ]
            ],
            "second_options"=>[
                "label"=>"Confirmez votre mots de passe",
                "attr"=>[
                "placeholder"=>"Confirmation votre mot de passe"
                ]
            ]
        ])
        -> add("submit",SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
