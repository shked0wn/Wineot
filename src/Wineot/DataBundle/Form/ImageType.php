<?php

namespace Wineot\DataBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fileuploaded', 'file', array(
            'data_class' => 'Doctrine\MongoDB\GridFSFile'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Image',
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_imagetype';
    }
} 