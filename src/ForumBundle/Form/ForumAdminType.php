<?php

namespace ForumBundle\Form;

use ForumBundle\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumAdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class, array(
            'label'    =>  'Title',
            'attr'     =>  array(
                'class' =>  'form-control'
            )))
                ->add('description',TextareaType::class, array(
                    'label'    =>  'Description',
                    'attr'     =>  array(
                        'class' =>  'form-control'
                    )))
                ->add('categorie',EntityType::class,array(
                    'class'=>Categories::class,
                    'choice_label'=>'libelle',
                    'multiple'  =>  false,
                    'expanded'  =>  false,
                    'required'  =>  false,
                    'label'     =>  'Catégorie',
                    'attr'      =>  array(
                        'class' =>  'form-control'
                    )
                ))
                ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Forum'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forumbundle_forum';
    }


}
