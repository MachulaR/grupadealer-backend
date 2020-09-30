<?php

namespace App\Form;

use App\Entity\Notification;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextType::class, [
                'required' => true,
            ])
            ->add('logins', TextType::class,  [
                'required' => true,
            ])
            ->add('search', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
            'csrf_protection' => false,
        ]);
    }
}
