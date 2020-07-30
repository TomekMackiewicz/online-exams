<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Survey;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('description', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('summary', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('duration', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('next_submission_after', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('ttl', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('use_pagination', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ]) 
            ->add('questions_per_page', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ])
            ->add('shuffle_questions', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ])
            ->add('immediate_answers', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ])
            ->add('restrict_submissions', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false
                ],
                'invalid_message' => 'validation.not_bool'
            ])
            ->add('allowed_submissions', TextType::class, [
                'invalid_message' => 'validation.not_string'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
            'csrf_protection' => false
        ]);
    }
}
