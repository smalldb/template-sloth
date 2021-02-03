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
use Symfony\Component\HttpFoundation\StreamedResponse;


class SlothStreamedResponse extends StreamedResponse implements SlothBasedResponse
{
	protected $sloth;


	public function __construct(Sloth $sloth, int $status = 200, array $headers = [])
	{
		parent::__construct(null, $status, $headers);
		$this->sloth = $sloth;
		$this->callback = function() { $this->sloth->display(); };
	}


	public function getSloth(): Sloth
	{
		if ($this->streamed) {
			throw new \LogicException('The content is already streamed away; Sloth is no longer available.');
		}
		return $this->sloth;
	}


	public static function create($callback = null, int $status = 200, array $headers = [])
	{
		throw new \LogicException('The deprecated factory method is not available: ' . static::class . '::create()');
	}


	public function setCallback(callable $callback)
	{
		throw new \LogicException('Cannot set the callback on SlothStreamedResponse.');
	}

}
