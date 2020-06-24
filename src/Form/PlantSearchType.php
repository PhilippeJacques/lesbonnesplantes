<?php

namespace App\Form;

use App\Entity\PlantSearch;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maladie',TextType::class,
                ['required'=>false,'label'=>false,'attr'=>['placeholder'=>"Recherche par Maladie"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlantSearch::class,
            'method'=>'get',
            'csrf_protection'=>false]);
    }
    public function  getBlockPrefix()
    {
        return '';
    }
}
