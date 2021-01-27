<?php declare(strict_types = 1);
/*
 * Copyright (c) 2021, Josef Kufner  <josef@kufner.cz>
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

namespace Smalldb\TemplateSloth\Tests;


class ConditionsTest extends TestCase
{

	public function testConditions()
	{
		$layout_twig = <<<EOF
			<html>
				{% if 'header' is empty_slot -%}
					No header.
				{%- else %}
				<header>
					{% slot 'header' %}
				</header>
				{% endif %}

				{% if 'content' is not empty_slot -%}
				<main>
					{% slot 'content' %}
				</main>
				{%- else -%}
					No content.
				{%- endif %}

			</html>
			EOF;

		$expectedOutput = <<<EOF
			<html>
				No header.
				<main>
					<div>Hello world!</div>
				</main>
			</html>
			EOF;

		$templates = [
			'layout.twig' => $layout_twig,
			'div.twig' => "<div>{{ text }}</div>\n",
		];

		$sloth = $this->spawnSloth($templates);
		$sloth->setLayout('layout.twig', []);

		$sloth['content']->add(50, 'div.twig', [ 'text' => 'Hello world!' ]);

		$this->expectOutputString($expectedOutput);
		$sloth->display();
	}
}
