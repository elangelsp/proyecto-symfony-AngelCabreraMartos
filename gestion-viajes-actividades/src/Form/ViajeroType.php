<?php

namespace App\Form;

use App\Entity\proyecto;
use App\Entity\Viajero;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre_completo')
            ->add('referencia')
            ->add('telefono')
            ->add('ciudad')
            ->add('pais')
            ->add('imagen')
            ->add('proyecto_id', EntityType::class, [
                'class' => proyecto::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Viajero::class,
        ]);
    }
}
