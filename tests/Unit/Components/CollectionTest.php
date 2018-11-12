<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Components;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Components\Collection;
use ReviewZorro\ValueObjects\FilePath;
use stdClass;

/**
 * @coversDefaultClass \ReviewZorro\Components\Collection
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CollectionTest extends TestCase
{
	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testShouldThrowExceptionIfArrayContainNotCompatiblePrimitiveTypes()
	{
		new Collection(['string'], stdClass::class);
	}

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testShouldThrowExceptionIfArrayContainNotCompatibleComplexTypes()
	{
		$collection = new Collection([new FilePath('/foo/bar')], FilePath::class);

		$collection->addItems([new stdClass()]);
	}

	/**
	 * @covers ::addItems
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testAddItems()
	{
		$collection = new Collection([0], 'int');
		$collection->addItems([1, 2, 3]);

		static::assertEquals([0, 1, 2, 3], (array)$collection);
	}

	/**
	 * @covers ::merge
	 * @covers ::count
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testMergeCollections()
	{
		$collection = new Collection(['first', 'second'], 'string');
		$other      = new Collection(['third', 'fourth'], 'string');

		$collection->merge($other);

		$result = $collection->count();

		static::assertEquals(4, $result);
	}

	/**
	 * @covers ::merge
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testSameElementsShouldBeCollapsedOnMerge()
	{
		$items = [new stdClass(), new stdClass()];

		$first  = new Collection($items, stdClass::class);
		$second = new Collection($items, stdClass::class);

		$first->merge($second, true);

		$result = (array)$first;

		static::assertEquals($items, $result);
	}

	public function testCheckBoolAndBoolean()
	{
		$items = [true, true];

		$collection = new Collection($items, 'bool');

		static::assertEquals($items, (array)$collection);
	}
}
