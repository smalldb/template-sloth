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

use Symfony\Component\HttpFoundation\StreamedResponse;
use Smalldb\TemplateSloth\TwigExtension\SlothExtension;


class Sloth implements \ArrayAccess
{
	protected $twig;

	protected $layout = null;
	protected $layout_attr = [];

	protected $slots = [];


	public function __construct(\Twig_Environment $twig, string $default_layout = null, array $default_layout_attrs = [])
	{
		$this->twig = $twig;
		$this->twig->addGlobal('_sloth', $this);

		if ($default_layout !== null) {
			$this->setLayout($default_layout, $default_layout_attrs);
		}
	}


	public function registerExtension()
	{
		$this->twig->addExtension(new SlothExtension());
	}


	public function setLayout(string $layout, array $attributes = null)
	{
		$this->layout = $layout;

		if ($attributes !== null) {
			$this->layout_attr = $attributes;
		}
	}


	public function setLayoutAttribute(string $attr, $value)
	{
		$this->layout_attr[$attr] = $value;
	}


	public function slot(string $slot_name)
	{
		if (!isset($this->slots[$slot_name])) {
			$this->slots[$slot_name] = new Slot($slot_name, $this);
		}

		return $this->slots[$slot_name];
	}


	public function display()
	{
		return $this->twig->display($this->layout, $this->layout_attr);
	}


	public function response($status = 200, $headers = [])
	{
		if ($this->layout === null) {
			throw new \RuntimeException('Layout not specified.');
		}

		return new StreamedResponse(function() {
			return $this->display();
		}, $status, $headers);
	}


	public function offsetExists($offset)
	{
		return isset($this->slots[$offset]);
	}


	public function offsetGet($offset)
	{
		return $this->slot($offset);
	}


	public function offsetSet($offset, $value)
	{
		throw \RuntimeException('Invalid operation.');
	}


	public function offsetUnset($offset)
	{
		throw \RuntimeException('Invalid operation.');
	}



}

