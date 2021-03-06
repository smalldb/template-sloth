Template Sloth
==============

Slot-based template extension.

See https://smalldb.org/template-sloth/

...


Installation
------------

Using Composer:

`````
composer require smalldb/template-sloth
`````

Symfony's `config.yml` — add `sloth` service, it will register into Twig
automatically:

```.yaml
services:
        sloth:
                class: Smalldb\TemplateSloth\Sloth
                arguments: [ '@twig' ]
```

Troubleshooting
---------------

> Error: Unexpected "slot" tag (expecting closing tag for the "…" tag defined near line …) in …

This means the Sloth did not install the Twig extension. Is your dependency
injection container configured properly?


Usage
-----

```.php
$sloth = $this->get('sloth');
$sloth->setLayout('layout.html.twig', [ 'user' => 'Alice']);
$sloth->slot('content')->add(10, 'template.html.twig', [ 'foo' => 'bar' ];
$sloth->slot('content')->add(20, 'template.html.twig', [ 'foo' => 'foo' ];
return $sloth->response();
```

```.twig
{% if 'content' is empty_slot %}
  No content available.
{% else %}
  {% slot 'content' %}
{% endif %}
```


Documentation
-------------

See https://smalldb.org/doc/template-sloth/master/


License
-------

The most of the code is published under Apache 2.0 license. See [LICENSE](Resources/doc/license.md) file for details.


Contribution guidelines
-----------------------

Project's primary repository is hosted at https://git.frozen-doe.net/smalldb/template-sloth,
feel free to submit issues there or create merge requests.


