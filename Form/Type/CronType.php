<?php

namespace BCC\CronManagerBundle\Form\Type;

use \Symfony\Component\Form\FormBuilder;
use \Symfony\Component\Form\AbstractType;

class CronType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method gets called for each type in the hierarchy starting from the
     * top most type.
     * Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilder $builder The form builder
     * @param array         $options The options
     */
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

    /**
     * Returns the default options for this type.
     *
     * @param array $options
     *
     * @return array The default options
     */
    public function getDefaultOptions(array $options) {
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
