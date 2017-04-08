<?php
/*
 * Copyright (c) 2017, Josef Kufner  <josef@kufner.cz>
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

namespace Smalldb\TemplateSloth\TwigExtension;

use Twig_Extension;
use Twig_SimpleTest as Twig_Test;
use Twig_SimpleFunction as Twig_Function;


class SlothExtension extends Twig_Extension
{

	public function getTokenParsers()
	{
		return [
			new SlotTokenParser(),
		];
	}


	public function getTests()
	{
		return [
			new Twig_Test('empty_slot', null, ['node_class' => 'Smalldb\TemplateSloth\TwigExtension\IsSlotEmptyTest']),
		];
	}


	public function getFunctions()
	{
		return [
			new Twig_Function('slot', null, ['node_class' => 'Smalldb\TemplateSloth\TwigExtension\SlotFunction']),
		];
	}

}

