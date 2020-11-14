<?php

declare(strict_types=1);

namespace ReviewZorro\Entities;

use InvalidArgumentException;

/**
 * Entity for files.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class File
{
	/** @var string */
	private $path;

	/**
	 * @param string $path
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(string $path)
	{
		if ('' === $path) {
			throw new InvalidArgumentException('File path can\'t be empty');
		}

		$this->path = $path;
	}

	/**
	 * @return string|null
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getExtension(): ?string
	{
		$parts = explode('.', $this->path);

		if (1 === count($parts)) {
			return null;
		}

		return end($parts);
	}

	/**
	 * @param bool $withExtension
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getName(bool $withExtension = true): string
	{
		$parts = explode(DIRECTORY_SEPARATOR, $this->path);

		$result = end($parts);
		if (false === $withExtension) {
			$result = str_replace('.' . $this->getExtension(), '', $result);
		}

		return $result;
	}

	/**
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getPath(): string
	{
		return $this->path;
	}
}
