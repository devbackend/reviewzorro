<?php

declare(strict_types=1);

namespace ReviewZorro\Contracts;

use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;

/**
 * Git changes component.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface GitInterfaces
{
	/**
	 * @return File[]
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getFiles(): array;

	/**
	 * @param Comment[] $comments
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function send(array $comments);
}
