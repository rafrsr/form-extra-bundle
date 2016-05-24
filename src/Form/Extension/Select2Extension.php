<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
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

    /**
     * @var RegistryInterface
     */
    private $doctrine;

    private $select2DefaultOptions
        = [
            'minimumResultsForSearch' => 20,
        ];

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating, RegistryInterface $doctrine = null)
    {
        $this->templating = $templating;
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var ChoiceView $choice */
        foreach ($view->vars['choices'] as $choice) {
            if ($options['select2_template_result']) {

                $object = $choice->value;
                if ($this->doctrine && $options['class']) {
                    $object = $this->doctrine->getRepository($options['class'])->find($object);
                }
                if (is_string($options['select2_template_result'])) {
                    $choice->attr['data-template-result'] = $this->templating->render(
                        $options['select2_template_result'],
                        [
                            'choice' => $choice,
                            'object' => $object
                        ]
                    );
                } else {
                    $choice->attr['data-template-result']
                        = call_user_func_array($options['select2_template_result'], [$choice, $object]);
                }
            }

            if ($options['select2_template_selection']) {

                $object = $choice->value;
                if ($this->doctrine && $options['class']) {
                    $object = $this->doctrine->getRepository($options['class'])->find($object);
                }
                if (is_string($options['select2_template_selection'])) {
                    $choice->attr['data-template-selection'] = $this->templating->render(
                        $options['select2_template_selection'],
                        [
                            'choice' => $choice,
                            'object' => $object
                        ]
                    );
                } else {
                    $choice->attr['data-template-selection']
                        = call_user_func_array($options['select2_template_selection'], [$choice, $object]);
                }
            }
        }

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
                'select2_template_result' => null,
                'select2_template_selection' => null,
            ]
        );
        $resolver->setAllowedTypes('select2', ['boolean']);
        $resolver->setAllowedTypes('select2_options', ['null', 'array']);
        $resolver->setAllowedTypes('select2_template_result', ['null', 'string', 'callable']);
        $resolver->setAllowedTypes('select2_template_selection', ['null', 'string', 'callable']);
    }

    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return ChoiceType::class;
    }
}