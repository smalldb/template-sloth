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

namespace Smalldb\TemplateSloth\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;
use Twig\TwigFunction;


class SlothExtension extends AbstractExtension
{

	public function getTokenParsers(): array
	{
		return [
			new SlotTokenParser(),
		];
	}


	public function getTests(): array
	{
		return [
			new TwigTest('empty_slot', null, ['node_class' => IsSlotEmptyTest::class]),
		];
	}


	public function getFunctions(): array
	{
		return [
			new TwigFunction('slot', null, ['node_class' => SlotFunction::class]),
		];
	}

}

