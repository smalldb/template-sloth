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

namespace Smalldb\TemplateSloth;

use Twig_Node;
use Twig_Node_Expression;
use Twig_Compiler;


class SlotNode extends \Twig_Node
{

	public function __construct($slot_name, $line, $tag = null)
	{
		parent::__construct(['slot_name' => $slot_name], [], $line, $tag);
	}

	public function compile(Twig_Compiler $compiler)
	{
		// include: $this->loadTemplate("included_file.html", "parent_file.html", 35)->display($context);
		$compiler->addDebugInfo($this);

		// Fragment foreach loop
		$compiler->write("\$slot = \$context['_sloth']->slot(")
			->subcompile($this->getNode('slot_name'))
			->raw(");\n");
		$compiler->write("while((\$fragment = \$slot->nextFragment()) !== null) {\n");
		$compiler->write("list(\$fragment_template, \$fragment_attr) = \$fragment;\n");

		// Include fragment template
		$compiler->write('$this->loadTemplate($fragment_template, ')
			->repr($this->getTemplateName())
			->raw(', ')
			->repr($this->getTemplateLine())
			->raw(')')
			->raw('->display($fragment_attr)')
			->raw(";\n");

		// End foreach
		$compiler->write("}\n");
	}

}

