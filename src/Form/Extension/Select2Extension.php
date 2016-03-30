<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class Select2Extension
 */
class Select2Extension extends AbstractTypeExtension
{
    /**
     * @var EngineInterface
     */
    private $templating;

    private $select2DefaultOptions
        = [
            'minimumResultsForSearch' => 20,
        ];

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @inheritdoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['select2'] === true) {
            $options['select2_options'] = array_merge($this->select2DefaultOptions, $options['select2_options']);
            $view->vars['select2_options'] = json_encode($options['select2_options']);
        }
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'select2' => true,
                'select2_options' => [],
            ]
        );
        $resolver->setAllowedTypes('select2', ['boolean']);
        $resolver->setAllowedTypes('select2_options', ['null', 'array']);
    }

    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return ChoiceType::class;
    }
}