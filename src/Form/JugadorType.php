<?php

namespace App\Form;

use App\Entity\Jugador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class JugadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte un nombre para el jugador',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'El nombre debe de tener minimo {{ limit }} caracteres',
                        'max' => 100,
                    ]),
                ]
            ])

            ->add('posicion', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte una posición para el jugador',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'La posición debe de tener minimo {{ limit }} caracteres',
                        'max' => 50,
                    ]),
                ]
            ])

            ->add('lugarNacimiento', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte un lugar de nacimiento para el jugador',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'El lugar de nacimiento debe de tener minimo {{ limit }} caracteres',
                        'max' => 50,
                    ]),
                ]
            ])

            ->add('fechaNacimiento', null, [

                'required'=> false, 

            ])


            ->add('foto', FileType::class, [
                'label' => 'Foto (.jpg .png)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                
            ])
            ->add('guardar', SubmitType::class, ['attr' => ['class' => 'btn btn-primary w-100 py-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jugador::class,
        ]);
    }
}