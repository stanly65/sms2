<?php

namespace SMS\SalesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use SMS\SalesBundle\Entity\SalesOrder;

class SalesOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    SalesOrder::STATUS_PROCESSING => SalesOrder::STATUS_PROCESSING,
                    SalesOrder::STATUS_CANCELED => SalesOrder::STATUS_CANCELED,
                    SalesOrder::STATUS_COMPLETE => SalesOrder::STATUS_COMPLETE,
                ],
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
            'data_class' => 'SMS\SalesBundle\Entity\SalesOrder'
        ]);
    }
}
