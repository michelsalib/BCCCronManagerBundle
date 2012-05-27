<?php

namespace BCC\CronManagerBundle\Form\Type;

use \Symfony\Component\Form\FormBuilder;
use \Symfony\Component\Form\AbstractType;

class CronType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('minute');
        $builder->add('hour');
        $builder->add('dayOfMonth');
        $builder->add('month');
        $builder->add('dayOfWeek');

        $builder->add('command');
        $builder->add('logFile', 'text', array(
            'required' => false,
        ));
        $builder->add('errorFile', 'text', array(
            'required' => false,
        ));
        $builder->add('comment', 'text', array(
            'required' => false,
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'BCC\CronManagerBundle\Manager\Cron',
        );
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
