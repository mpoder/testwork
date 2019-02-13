<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicCommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      dump($options["data"]->getNews()->getID());
        $builder
            ->add('email')
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
