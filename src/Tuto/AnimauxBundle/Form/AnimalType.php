<?php

namespace Tuto\AnimauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnimalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text', array('label'=>'Titre de l\'article'))
            ->add('description', 'textarea',array('attr' => array('class' => 'ckeditor')))
            ->add('url', 'text', array('required'=>false))
            ->add('date', 'datetime')
            //->add('image', new ImageType())

            ->add('categorie','entity', array('class'=>'TutoAnimauxBundle:Categorie',
                                               'property'=>'nom',
                                               'multiple'=>false,
                                               'expanded'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tuto\AnimauxBundle\Entity\Animal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tuto_animauxbundle_animal';
    }
}

?>
