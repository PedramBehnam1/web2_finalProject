<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roomNumber')
            ->add('capacity')
            ->add('maximumCapacity')
            ->add('isEmpty')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdUsername')
            ->add('updatedUsername')
            ->add('userAccounts')
            ->add('dorm')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
