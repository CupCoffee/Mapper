# Reify

Mapping things like json,xml, arrays and simply every kind of data a concrete instances. Avoid having to hassle with array keys or undefined exceptions when trying to
get a json property. Stop thinking and Yolo to the **Getting Started**

## Getting Started
Interesting, you're getting curious right? First install this package

```
composer require "cupcoffee/mapper"
```

Once you've done that we need a concrete class to map your data to:

```php
//Person.php

class Person
{
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $gender;

	/**
	 * @var string
	 */
	public $age;
}
```

Lastly we let **Reify** handle the real work

```php
$json = '{
  "name": "John Johnson",
  "age": "23",
  "gender": "Male"
}';

$person = (new Mapper())->map(new JsonMapper(), $json)->to(Person::class);
```




## Where does this awesome name come from!?
Wow you were just thinking the same as we did! 

> Reify is a word that attempts to provide a bridge between what is abstract and what is real.

[source](http://www.merriam-webster.com/dictionary/reify)

In essential that is wat this package is; you give **Reify** some data and it will make it concrete for you
