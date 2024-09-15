<?php

namespace App\Form;

use App\Form\Choices\LimitChoiceEnum;
use App\Form\Choices\SubjectChoicesStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Search fied do not work yet'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => SubjectChoicesStatusEnum::getChoices(),
                'label' => false
            ])
            ->add('limit', ChoiceType::class, [
                'choices' => LimitChoiceEnum::getChoicesWithValues(),
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}