Template Sloth
==============

Slot-based template extension.

See https://smalldb.org/template-sloth/

...


Installation
------------

Using Composer:

```
{
    "require": {
        "smalldb/template-sloth": "dev-master"
    },
}
```

Symfony's `config.yml` — add `sloth` service, it will register into Twig
automatically:

```
services:
        sloth:
                class: Smalldb\TemplateSloth\Sloth
                arguments: [ '@twig' ]
```


Usage
-----

...


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


