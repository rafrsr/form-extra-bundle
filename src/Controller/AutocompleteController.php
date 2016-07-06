<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\Controller;

use Rafrsr\FormExtraBundle\Autocomplete\AutocompleteContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AutocompleteController extends Controller
{
    public function autoCompleteAction(Request $request)
    {
        $context = $this->get('rafrsr_form.autocomplete.context_manager')->getContext($request->get('_context'));

        if (!$context || !($context instanceof AutocompleteContextInterface)) {
            throw new \RuntimeException('Invalid context');
        }

        $provider = $this->get('rafrsr_form.autocomplete.provider_manager')->getProvider($context->getProvider());

        $results = $provider->fetchResults($request, $context);

        return $provider->buildResponse($results, $context);
    }
}