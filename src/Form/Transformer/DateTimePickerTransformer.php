<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTimePickerTransformer implements DataTransformerInterface
{
    protected $formatter;
    protected $customFormat;

    public function __construct(\IntlDateFormatter $formatter, $customFormat)
    {
        $this->formatter = $formatter;
        $this->customFormat = $customFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof \DateTime) {
            $value = new \DateTime($value);
        }

        if (null !== $this->customFormat) {
            return $value->format($this->customFormat);
        }

        return $this->formatter->format($value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string.');
        }

        if ('' === $value) {
            return null;
        }

        try {
            return new \DateTime($value);
        } catch (\Exception $e) {
            throw new TransformationFailedException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
