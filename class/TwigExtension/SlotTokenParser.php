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

use Twig\TokenParser\AbstractTokenParser;
use Twig\Token;


class SlotTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): SlotNode
	{
		$parser = $this->parser;
		$stream = $parser->getStream();

		$slot_name = $parser->getExpressionParser()->parseExpression();
		$stream->expect(Token::BLOCK_END_TYPE);

		return new SlotNode($slot_name, $token->getLine(), $this->getTag());
	}


	public function getTag(): string
	{
		return 'slot';
	}

}

