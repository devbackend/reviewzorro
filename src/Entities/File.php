<?php

declare(strict_types=1);

namespace ReviewZorro\Entities;

use Ramsey\Uuid\UuidInterface;
use ReviewZorro\ValueObjects\FilePath;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class File {
	/** @var UuidInterface */
	private $id;

	/** @var FilePath */
	private $path;

	public function __construct(UuidInterface $id, FilePath $path) {
		$this->id   = $id;
		$this->path = $path;
	}

	/**
	 * @return UuidInterface
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getId(): UuidInterface {
		return $this->id;
	}

	/**
	 * @return FilePath
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getPath(): FilePath {
		return $this->path;
	}
}
