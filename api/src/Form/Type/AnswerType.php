<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Answer;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('is_correct', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ])
            ->add('message', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('points', IntegerType::class, [
                'invalid_message' => 'validation.not_int'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
            'csrf_protection' => false
        ]);
    }
}
