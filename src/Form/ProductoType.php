<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte un nombre para el producto',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'El nombre debe de tener minimo {{ limit }} caracteres',
                        'max' => 100,
                    ]),
                ]
            ])

            ->add('precio', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte un precio para el producto',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'El precio debe de tener minimo {{ limit }} caracteres',
                        'max' => 10,
                    ]),
                ]
            ])

            ->add('stock', null, [

                'required'=> false, 
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, inserte un stock para el producto',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'El stock debe de tener minimo {{ limit }} caracteres',
                        'max' => 10,
                    ]),
                ]
            ])

            ->add('descripcion', null, [

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
            'data_class' => Producto::class,
        ]);
    }
}