<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Sale;
use App\Entity\SaleItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SaleItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a product',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('quantity', NumberType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('discount', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SaleItem::class,
            'sale' => null
        ]);

        $resolver->setAllowedTypes('sale', [Sale::class, 'null']);
    }
}

