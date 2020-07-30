<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Question;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('description', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('type', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('hint', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('is_required', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ])
            ->add('shuffle_answers', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'csrf_protection' => false
        ]);
    }
}
