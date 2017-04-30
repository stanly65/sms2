<?php

namespace SMS\PaymentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'constraints' => new Length(['min' => 16]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('expiryDate', TextType::class, [
                'constraints' => new Length(['min' => 4]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('securityCode', TextType::class, [
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
            'data_class' => 'SMS\PaymentBundle\Entity\Card'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'SMS_paymentbundle_card';
    }


}
