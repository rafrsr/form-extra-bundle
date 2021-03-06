<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

class AngularControllerType extends AbstractType
{
    /**
     * @var EngineInterface
     */
    private $templating;

    private $select2DefaultOptions
        = [
            'minimumResultsForSearch' => 20,
            'minimumInputLength' => 0,
        ];

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['controller_body']) {
            $view->vars['controller_body'] = $this->templating->render(
                $options['controller_body'],
                [
                    'form' => $form->getParent(),
                ]
            );
        }

        $view->vars['angular_modules'] = json_encode($options['angular_modules']);
        $view->vars['angular_services'] = json_encode($options['angular_services']);
        $view->vars['angular_services_array'] = $options['angular_services'];
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'rafrsr_form_angular_form';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'controller_body' => null,
                'angular_modules' => [],
                'angular_services' => ['$scope'],
            ]
        );

        $resolver->setAllowedTypes('controller_body', ['null', 'string']);
        $resolver->setAllowedTypes('angular_modules', ['array']);
        $resolver->setAllowedTypes('angular_services', ['array']);
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return HiddenType::class;
    }
}