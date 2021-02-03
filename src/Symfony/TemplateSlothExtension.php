<?php declare(strict_types=1);
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

use Smalldb\TemplateSloth\Symfony\Configuration;
use Smalldb\TemplateSloth\Sloth;
use Smalldb\TemplateSloth\Symfony\ArgumentValueResolver;
use Smalldb\TemplateSloth\TwigExtension\SlothExtension;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class TemplateSlothExtension extends ConfigurableExtension
{

	public function getConfiguration(array $config, ContainerBuilder $container): Configuration
	{
		return new Configuration();
	}


	public function loadInternal(array $mergedConfig, ContainerBuilder $container)
	{
		$defaultLayout = $mergedConfig['default_layout'] ?? null;

		$container->autowire(Sloth::class, Sloth::class)
			->setArguments([new Reference('twig'), $defaultLayout, []])
			->setAutoconfigured(true)
			->setLazy(true);

		$container->autowire(SlothExtension::class, SlothExtension::class)
			->addTag('twig.extension', [])
			->setLazy(true);

		$container->autowire(ArgumentValueResolver::class, ArgumentValueResolver::class)
			->setArguments([new Reference(Sloth::class)])
			->addTag('controller.argument_value_resolver', ['priority' => 50]);

	}

}

