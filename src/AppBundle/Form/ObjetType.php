<?php

namespace AppBundle\Form;

use AppBundle\Entity\Acheteur;
use Sedona\SBORuntimeBundle\Form\Type\EntitySelect2Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('dateVente')
            ->add('dateOnline', 'datetime')
            -> add('acheteur', EntitySelect2Type::class, [
                'searchRouteName'=> "search_acheteur",
                'property'=> 'name',
                'class' => Acheteur::class,
                'placeholder'=> 'Non trouvé dans la base'
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Objet'
        ));
    }
}
