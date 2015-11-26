<?php
/**
 * User: floran
 * Date: 30/03/15
 * Time: 17:16
 */

namespace Wineot\DataBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VintageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productionYear', 'choice', array(
            'label' => 'crud.form.wine.vintage',
            'choices' => array_combine(range(date('Y'), date('Y') - 100), range(date('Y'), date('Y') - 100)),
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('keeping', 'choice', array(
            'label' => 'crud.form.wine.keeping',
            'choices' => array_combine(range(date('Y') - 50, date('Y') + 50), range(date('Y')-50, date('Y') + 50)),
            'placeholder' => 'crud.form.wine.keeping',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('peak', 'choice', array(
            'label' => 'crud.form.wine.peak',
            'choices' => array_combine(range(date('Y') - 50, date('Y') + 50), range(date('Y')-50, date('Y') + 50)),
            'placeholder' => 'crud.form.wine.peak',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('labelPicture', new ImageType(), array(
            'label' => 'wine.form.label_picture',
            'required' => false
        ));
        $builder->add('bottlePicture', new ImageType(), array(
            'label' => 'wine.form.bottle_picture',
            'required' => false
        ));
        $builder->add('containsSulphites', 'checkbox', array(
            'label' => 'crud.form.wine.containsSulphites',
            'required' => false
        ));
        $builder->add('isBio', 'checkbox', array(
            'label' => 'crud.form.wine.isBio',
            'required' => false
        ));
        $builder->add('alcohol', 'percent', array(
            'label' => 'crud.form.wine.alcohol',
            'scale' => 2,
            'type' => 'integer',
            'required' => false

        ));
        $builder->add('wineryPrice', 'money', array(
            'label' => 'crud.form.wine.price',
            'required' => false

        ));
        $builder->add('tasteProfile', new TasteProfileType(), array(
            'label' => 'wine.form.taste_profile',
            'required' => false

        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Vintage'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_vintagetype';
    }
}