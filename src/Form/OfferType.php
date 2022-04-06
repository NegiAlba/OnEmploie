<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('salary')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => true,
                'required' => true,
                'expanded' => true,
            ])
            ->add('contractType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}