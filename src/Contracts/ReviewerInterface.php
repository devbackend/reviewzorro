<?php

namespace ReviewZorro\Contracts;

use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;

/**
 * Reviewer for file.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface ReviewerInterface
{
	/**
	 * @param File[] $files
	 *
	 * @return Comment[]
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function review(array $files): array;
}
