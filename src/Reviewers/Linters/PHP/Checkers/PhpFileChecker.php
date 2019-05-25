<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\PHP\Checkers;

use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;

/**
 * Interface for checking php file.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface PhpFileChecker
{
	/**
	 * @param File $file
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getCommand(File $file): string;

	/**
	 * @param string $commandOutput
	 *
	 * @return Comment[]
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function parse(string $commandOutput): array;
}
