<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Components;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Components\Collection;
use stdClass;

/**
 * Tests for \ReviewZorro\Components\Collection.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CollectionTest extends TestCase
{
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testShouldThrowExceptionIfArrayContainNotCompatibleTypes()
	{
		new Collection(['string'], stdClass::class);
	}

	public function testAddItems()
	{
		$items = [1, 2, 3];

		$collection = new Collection([], 'int');
		$collection->addItems($items);

		static::assertEquals($items, (array)$collection);
	}

	public function testMergeCollections()
	{
		$collection = new Collection(['first', 'second'], 'string');
		$other      = new Collection(['third', 'fourth'], 'string');

		$collection->merge($other);

		$result = $collection->count();

		static::assertEquals(4, $result);
	}

	public function testSameElementsShouldBeCollapsedOnMerge()
	{
		$items = [new stdClass(), new stdClass()];

		$first  = new Collection($items, stdClass::class);
		$second = new Collection($items, stdClass::class);

		$first->merge($second, true);

		$result = (array)$first;

		static::assertEquals($items, $result);
	}
}
