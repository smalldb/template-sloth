--TEST--
Initialization
--FILE--
<?php

require(__DIR__.'/init.php');

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

$templates = [
	'layout.twig' => $layout_twig,
	'div.twig' => "<div>{{ text }}</div>\n",
];

$sloth = init_sloth($templates);
$sloth->setLayout('layout.twig', []);

$sloth['content']->add(50, 'div.twig', [ 'text' => 'Hello world!' ]);

$sloth->display();

?>
--EXPECT--
<html>
	No header.
	<main>
		<div>Hello world!</div>
	</main>
</html>

