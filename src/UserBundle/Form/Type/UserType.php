<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType {

    public function buidForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('username');
        $builder->add('email');
        $builder->add('password');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
    
    public function getName()
    {
        return 'User';
    }

}
