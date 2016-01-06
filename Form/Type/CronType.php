<?php

namespace BCC\CronManagerBundle\Form\Type;

use \Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CronType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $textType = 'Symfony\Component\Form\Extension\Core\Type\TextType';
        } else {
            $textType = 'text';
        }

        $builder
            ->add('minute')
            ->add('hour')
            ->add('dayOfMonth')
            ->add('month')
            ->add('dayOfWeek')
            ->add('command')
            ->add('logFile', $textType, array(
                'required' => false,
            ))
            ->add('errorFile', $textType, array(
                'required' => false,
            ))
            ->add('comment', $textType, array(
                'required' => false,
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BCC\CronManagerBundle\Manager\Cron'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    function getName()
    {
        return 'cron';
    }
}
