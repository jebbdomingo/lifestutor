<?php

namespace Lifestutor\InventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            //->add('catalogs', 'collection', array('type' => new CatalogType()))
            ->add('name')
            ->add('code')
            ->add('cost')
            ->add('sellingPrice')
            ->add('quantity')
            ->add('rewardPoint')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lifestutor\InventoryBundle\Document\Book',
            'csrf_protection' => false,
            'error_bubbling' => true,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'book';
    }
}