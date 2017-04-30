<?php

namespace SMS\CatalogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use SMS\CatalogBundle\Entity\Category;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('price', NumberType::class, [
                'constraints' => new GreaterThan(0),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('qty', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('onsale', CheckboxType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('category', EntityType::class, [
                'class' => 'SMSCatalogBundle:Category',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SMS\CatalogBundle\Entity\Product'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'SMS_catalogbundle_product';
    }
}
