<?php


namespace App;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation',null)
            ->add('date_creation',null,
                ['label' => 'Date de création']
                )
            ->add('label',null,
                ['label' => 'Label']
                )
            ->add('description',null,
            ['label' => 'Description']
            )

            ->add('image_of_product', FileType::class, [
                'label' => 'Image de produit',

                // unmapped means that this field is not associated to any entity property
              //  'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                /*'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],*/
            ])


            ->getForm();
    }

}