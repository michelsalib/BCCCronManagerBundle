<?php

namespace BCC\CronManagerBundle\Form\Type;

use \Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CronType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minute')
            ->add('hour')
            ->add('dayOfMonth')
            ->add('month')
            ->add('dayOfWeek')
            ->add('command')
            ->add('logFile', 'text', array(
                'required' => false,
            ))
            ->add('errorFile', 'text', array(
                'required' => false,
            ))
            ->add('comment', 'text', array(
                'required' => false,
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
