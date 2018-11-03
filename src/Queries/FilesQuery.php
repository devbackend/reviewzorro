<?php

declare(strict_types=1);

namespace ReviewZorro\Queries;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FilesQuery
{
	/** @var int */
	private $count;

	/** @var string */
	private $extension;

	/**
	 * @param int $count
	 *
	 * @return FilesQuery
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function setCount(int $count): FilesQuery
	{
		$this->count = $count;

		return $this;
	}

	/**
	 * @return int
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getCount(): int
	{
		return $this->count;
	}

	/**
	 * @param string $extension
	 *
	 * @return FilesQuery
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function setExtension(string $extension): FilesQuery
	{
		$this->extension = $extension;

		return $this;
	}

	/**
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getExtension(): string
	{
		return $this->extension;
	}
}
