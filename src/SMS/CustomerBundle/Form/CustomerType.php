<?php

namespace SMS\CustomerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => new Email,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('username', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('firstName', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('lastName', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('phoneNumber', TextType::class, [
                'constraints' => new Length(['min' => 7]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('country', CountryType::class, 
                ['attr' => ['class' => 'form-control']])
            ->add('city', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('postcode', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('street', TextType::class, [
                'constraints' => new Length(['min' => 3]),
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
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }
}
