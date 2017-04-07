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


class Slot
{
	protected $sloth;
	protected $slot_name;

	protected $fragmentQueue;
	protected $serial = 1;


	public function __construct($slot_name, Sloth $sloth)
	{
		$this->slot_name = $slot_name;
		$this->sloth = $sloth;
		$this->fragmentQueue = new \SplPriorityQueue();
		$this->fragmentQueue->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
	}


	/**
	 * Add a fragment into the slot queue.
	 */
	public function add(int $weight, $template, $arguments = [])
	{
		// Penalty stabilizes sort used by the queue
		// lim_{$serial -> inf} $penalty  =  0
		$penalty = 1 - 100. / (100. + $this->serial); 
		$this->fragmentQueue->insert([$template, $arguments], - $weight - $penalty);
		$this->serial++;
	}


	/**
	 * Returns the fragment on top of the queue and removes it (shifts up).
	 * When queue is empty, null is returned.
	 */
	public function nextFragment()
	{
		if ($this->fragmentQueue->isEmpty()) {
			return null;
		} else {
			return $this->fragmentQueue->extract();
		}
	}

}

