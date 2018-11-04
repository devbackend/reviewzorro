<?php

declare(strict_types=1);

namespace ReviewZorro\Components;

use ArrayIterator;
use InvalidArgumentException;

/**
 * Collection of selected types.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class Collection extends ArrayIterator
{
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
			$this[] = $item;
		}
	}

	/**
	 * @param Collection $collection
	 * @param bool       $collapseSame
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function merge(Collection $collection, bool $collapseSame = false)
	{
		$items = [];
		foreach ($collection as $item) {
			if (false === $collapseSame || false === array_search($item, (array)$this)) {
				$items[] = $item;
			}
		}

		$this->addItems($items);
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
