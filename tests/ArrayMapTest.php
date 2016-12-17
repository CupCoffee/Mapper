<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Reify\Data\ArrayMapper;
use Reify\Data\JsonMapper;
use Reify\Mapper;
use Reify\Tests\Objects\Person;

class ArrayMapTest extends TestCase
{
//	public function testArrayToClass()
//	{
//		$array = [
//			'name'   => 'John Johnson',
//			'age'    => '23',
//			'gender' => 'male'
//		];
//
//		$person = (new Mapper())->map(new JsonMapper(), $array)->to(Person::class);
//
//		$this->assertInstanceOf(Person::class, $person);
//	}

	protected function map($data)
	{
		return (new Mapper())->map(new ArrayMapper(), $data)->to(Person::class);
	}

	public function testMapToClass()
	{
		$data = [];
		$instance = $this->map($data);

		$this->assertInstanceOf(Person::class, $instance);
	}

	public function testMapStringProperty()
	{
		$data = ['name' => 'John Johnson'];
		$instance = $this->map($data);

		$this->assertTrue($instance->name == 'John Johnson');
	}

	public function testMapBooleanProperty()
	{
		$data = ['isAwesome' => 1];
		$instance = $this->map($data);

		$this->assertTrue($instance->isAwesome === true, 'Mapping number 1 to a boolean');

		$data = ['isAwesome' => true];
		$instance = $this->map($data);

		$this->assertTrue($instance->isAwesome === true, 'Mapping true to a boolean');
	}
	
	public function testMapIntegerProperty()
	{
		$data = ['age' => 1];
		$instance = $this->map($data);

		$this->assertTrue($instance->age === 1, 'Mapping number 1 to a number');
	}
	

}