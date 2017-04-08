--TEST--
A simple slot use
--FILE--
<?php

require(__DIR__.'/init.php');

$templates = [
	'layout.twig' => "<html class=\"{{ html_class }}\">\n{% slot 'content' %}\n</html>\n",
	'div.twig' => "<div>{{ text }}</div>\n",
];

$sloth = init_sloth($templates);
$sloth->setLayout('layout.twig', [ 'html_class' => 'hello' ]);

$sloth['content']->add(50, 'div.twig', [ 'text' => 'Bye world!' ]);
$sloth['content']->add(30, 'div.twig', [ 'text' => 'Hello world!' ]);

$sloth->display();

?>
--EXPECT--
<html class="hello">
<div>Hello world!</div>
<div>Bye world!</div>
</html>

