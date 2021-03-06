<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Autocomplete;

interface AutocompleteContextInterface
{
    /**
     * Name of the service to use to fetch results
     *
     * @return string
     */
    public function getProvider();

    /**
     * @param string $provider
     *
     * @return $this
     */
    public function setProvider($provider);

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters($parameters);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setParameter($name, $value);

    /**
     * @param string     $name
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function getParameter($name, $default = null);

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function hasParameter($name);
}