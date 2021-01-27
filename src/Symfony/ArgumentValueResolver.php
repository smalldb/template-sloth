<?php
/*
 * Copyright (c) 2017-2021, Josef Kufner  <josef@kufner.cz>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace Smalldb\TemplateSloth\Symfony;

use Smalldb\TemplateSloth\Sloth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;


class ArgumentValueResolver implements ArgumentValueResolverInterface
{
	protected $sloth;


	public function __construct(Sloth $sloth)
	{
		$this->sloth = $sloth;
	}


	public function supports(Request $request, ArgumentMetadata $argument)
	{
		return (Sloth::class === $argument->getType());
	}


	public function resolve(Request $request, ArgumentMetadata $argument)
	{
		yield $this->sloth;
	}

}

