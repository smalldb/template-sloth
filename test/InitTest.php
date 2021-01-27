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


class InitTest extends TestCase
{

	public function testInit()
	{
		$sloth = $this->spawnSloth([]);
		$this->assertInstanceOf(\Smalldb\TemplateSloth\Sloth::class, $sloth);
	}


	public function testSlot()
	{
		$templates = [
			'layout.twig' => "<html class=\"{{ html_class }}\">\n"
				. "{% slot 'content' %}\n</html>\n",
			'div.twig' => "<div>{{ text }}</div>\n",
		];

		$sloth = $this->spawnSloth($templates);
		$sloth->setLayout('layout.twig', [ 'html_class' => 'hello' ]);

		$sloth['content']->add(50, 'div.twig', [ 'text' => 'Bye world!' ]);
		$sloth['content']->add(30, 'div.twig', [ 'text' => 'Hello world!' ]);

		$this->expectOutputString("<html class=\"hello\">\n"
			. "<div>Hello world!</div>\n"
			. "<div>Bye world!</div>\n"
			. "</html>\n");
		$sloth->display();
	}
}
