<?php

declare(strict_types=1);

namespace ReviewZorro\Entities;

use ReviewZorro\ValueObjects\FilePath;

/**
 * Entity for files.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class File
{
	/** @var FilePath */
	private $path;

	/**
	 * @param FilePath $path
	 *
	 * @author Кривонос Иван <krivonos.iv@dns-shop.ru>
	 */
	public function __construct(FilePath $path)
	{
		$this->path = $path;
	}

	/**
	 * @return FilePath
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getPath(): FilePath
	{
		return $this->path;
	}
}
