<?php

declare(strict_types=1);

namespace ReviewZorro\Components;

use ArrayIterator;
use InvalidArgumentException;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class Collection extends ArrayIterator
{
    /** @var array */
    private $items;

    /** @var string */
    private $type;

    /**
     * @param array $items
     * @param string $type
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function __construct(array $items, string $type)
    {
        if ('int' === $type) {
            $type = 'integer';
        } elseif ('bool' === $type) {
            $type = 'boolean';
        }

        $this->type = $type;
        $this->items = [];

        $this->addItems($items);
    }

    /**
     * @param array $items
     *
     * @throws InvalidArgumentException
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function addItems(array $items)
    {
        $this->checkItems($items);

        foreach ($items as $item) {
            $this->items[] = $item;
        }
    }

    /**
     * @return array
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Collection $collection
     * @param bool $collapseSame
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function merge(Collection $collection, bool $collapseSame = false)
    {
        $items = [];
        foreach ($collection->getItems() as $item) {
            if (false === $collapseSame || false === array_search($item, $this->items)) {
                $items[] = $item;
            }
        }

        $this->addItems($items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param array $items
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    private function checkItems(array $items)
    {
        foreach ($items as $item) {
            if (is_object($item) && $item instanceof $this->type) {
                continue;
            } elseif (getType($item) === $this->type) {
                continue;
            }

            $type = is_object($item)
                ? get_class($item)
                : gettype($item);

            throw new InvalidArgumentException(
                implode(
                    ' ',
                    [
                        'Collection must contain only',
                        $this->type.';',
                        $type,
                        'received!',
                    ]
                )
            );
        }
    }
}
