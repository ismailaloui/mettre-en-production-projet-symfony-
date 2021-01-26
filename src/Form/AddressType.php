<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Quel nom souhaitez-vous donner à votre adresse',
                'attr'=>[
                    'placeholder'=>'Nommez votre adresse'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>'Entrez  votre Prenom',
                'attr'=>[
                    'placeholder'=>'Nommez votre prenom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Entrez votre nom',
                'attr'=>[
                    'placeholder'=>'Nommez votre nom'
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>'Votre Sosciété',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'(facultatif) Entrez le nom de votre société '
                ]
            ])
            ->add('address',TextType::class,[
                'label'=>'Votre adresse',
                'attr'=>[
                    'placeholder'=>'8 Rue Du Roussel .....'
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>'Votre code postale',
                'attr'=>[
                    'placeholder'=>'Entrez votre code postale'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Votre ville',
                'attr'=>[
                    'placeholder'=>'Carcassone ...'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Pays',
                'attr'=>[
                    'placeholder'=>'Votre pays'
                ]
            ])
            ->add('phone',TelType::class,[
                'label'=>'Votre téléphone',
                'attr'=>[
                    'placeholder'=>'003366.....'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider',
                'attr'=>['class'=>'btn-block btn-info']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
