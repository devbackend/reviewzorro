<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\PHP;

use ReviewZorro\Contracts\ReviewerInterface;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpFileChecker;

/**
 * Linter for PHP files.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
final class PHPLinterReviewer implements ReviewerInterface
{
	/** @var PhpFileChecker[] */
	private $checkers = [];

	public function addChecker(PhpFileChecker $checker)
	{
		$this->checkers[] = $checker;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function review(array $files): array
	{
		$result = [];
		foreach ($files as $file) {
			if ('php' !== $file->getExtension()) {
				continue;
			}

			foreach ($this->checkers as $checker) {
				$output = null;
				exec($checker->getCommand($file), $output);

				$result = array_merge($result, $checker->parse(implode(PHP_EOL, $output)));
			}
		}

		return $result;
	}
}
