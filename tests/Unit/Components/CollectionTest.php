<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Components;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Components\Collection;
use stdClass;
use Traversable;

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
    public function testShouldThrowExceptionIfArrayContainNotCompatibleTypes()
    {
        new Collection(['string'], stdClass::class);
    }

    /**
     * @coversNothing
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function testAddItems()
    {
        $items = [1, 2, 3];

        $collection = new Collection([], 'int');
        $collection->addItems($items);

        static::assertEquals($items, $collection->getItems());
    }

    /**
     * @coversNothing
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function testCollectionShouldBeTraversable()
    {
        static::assertInstanceOf(Traversable::class, new Collection([], 'int'));
    }

    /**
     * @covers ::getItems
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function testGetItems()
    {
        $items = [new stdClass()];

        $collection = new Collection($items, stdClass::class);
        $result = $collection->getItems();

        static::assertEquals($items, $result);
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
        $other = new Collection(['third', 'fourth'], 'string');

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

        $result = $first->getItems();

        static::assertEquals($items, $result);
    }
}
