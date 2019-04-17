<?php

namespace Tuto\AnimauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentairesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur')
            ->add('commentaire')
            //->add('date')
            //->add('animal')
            /*
             * 
            ->add('date')
            ->add('animal','entity', array('class'=>'TutoAnimauxBundle:Animal',
                                   'property'=>'titre',
                                   'multiple'=>false,
                                   'expanded'=>false))
            
             */
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tuto\AnimauxBundle\Entity\Commentaires'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tuto_animauxbundle_commentaires';
    }
}
