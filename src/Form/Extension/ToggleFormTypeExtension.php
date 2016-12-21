<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ToggleFormTypeExtension
 */
class ToggleFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @inheritdoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        //TODO: support for expanded choices (radio buttons)

        if (isset($options['toggle_group'])) {
            $groups = (array)$options['toggle_group'];

            if ($groups) {
                $view->vars['toggle_groups'] = $groups;
            }
        }

        if (isset($options['toggle'])
            || isset($options['toggle_prefix'])
        ) {
            $view->vars['toggle'] = true;

            //convert into class name
            if ($options['toggle']) {
                $view->vars['attr']['data-toggle'] = '.toggle_group_' . $options['toggle'];
                $view->vars['attr']['data-reverse-toggle'] = '.toggle_group_not_' . $options['toggle'];
            }

            if ($options['toggle_prefix']) {
                $view->vars['attr']['data-toggle-prefix'] = '.toggle_group_' . $options['toggle_prefix'];
                $view->vars['attr']['data-toggle-reverse-prefix'] = '.toggle_group_not_' . $options['toggle_prefix'];
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'toggle' => null,
                'toggle_prefix' => null,
                'toggle_group' => null,
            ]
        );

        $resolver->setAllowedTypes('toggle', ['null', 'string']);
        $resolver->setAllowedTypes('toggle_prefix', ['null', 'string']);
        $resolver->setAllowedTypes('toggle_group', ['null', 'string', 'array']);
    }

    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return FormType::class;
    }
}