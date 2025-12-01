<?php

namespace App\Form;

use App\Entity\Logistica;
use App\Entity\viajero;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class LogisticaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo_viaje', ChoiceType::class, [
                'choices'  => [
                    'Ida' => 'Ida',
                    'Vuelta' => 'Vuelta',
                ],
            ])
            ->add('destino_lugar')
            ->add('medio_transporte')
            ->add('salida')
            ->add('llegada')
            ->add('viajero_id', EntityType::class, [
                'class' => viajero::class,
                'choice_label' => 'nombre_completo',
                'label' => 'Viajero',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logistica::class,
        ]);
    }
}
