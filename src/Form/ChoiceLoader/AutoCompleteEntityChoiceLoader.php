<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Form\ChoiceLoader;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;

class AutocompleteEntityChoiceLoader implements ChoiceLoaderInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AutocompleteEntityChoiceLoader constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritDoc
     */
    public function loadChoiceList($value = null)
    {
        return new ArrayChoiceList([4,2]);
    }

    /**
     * @inheritDoc
     */
    public function loadChoicesForValues(array $values, $value = null)
    {
       return ['Hola'];
    }

    /**
     * @inheritDoc
     */
    public function loadValuesForChoices(array $choices, $value = null)
    {
        return [3,'2'];
    }
}