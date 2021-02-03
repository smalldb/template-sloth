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

namespace Smalldb\TemplateSloth\Symfony;

use Smalldb\TemplateSloth\Sloth;
use Symfony\Component\HttpFoundation\Response;


class SlothResponse extends Response implements SlothBasedResponse
{
	protected $sloth;
	protected $isRendered = false;

	public function __construct(Sloth $sloth, int $status = 200, array $headers = [])
	{
		parent::__construct(null, $status, $headers);
		$this->sloth = $sloth;
	}


	public function getSloth(): Sloth
	{
		if ($this->isRendered) {
			throw new \LogicException('The content is already rendered; Sloth is no longer available.');
		}
		return $this->sloth;
	}


	public function setContent(?string $content)
	{
		if ($content === null) {
			$this->content = '';
		} else {
			$this->isRendered = true;
			$this->content = $content;
		}
		return $this;
	}


	public function getContent()
	{
		if ($this->isRendered) {
			return $this->content;
		} else {
			$this->isRendered = true;
			return ($this->content = $this->sloth->render());
		}
	}


	public function sendContent()
	{
		if ($this->isRendered) {
			echo $this->content;
		} else {
			$this->isRendered = true;
			echo ($this->content = $this->sloth->render());
		}
		return $this;
	}

}
