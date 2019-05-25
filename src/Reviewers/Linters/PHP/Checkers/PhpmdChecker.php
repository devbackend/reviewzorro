<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\PHP\Checkers;

use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\ValueObjects\CommentedFile;

/**
 * Phpcs file checker.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdChecker implements PhpFileChecker
{
	/** @var string|null */
	protected $standard;

	public function __construct(?string $standard = null)
	{
		$this->standard = $standard ?? PathHelper::path('phpmd.xml');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getCommand(File $file): string
	{
		$command = [
			PathHelper::path('vendor', 'bin', 'phpmd'),
			$file->getPath(),
			'text',
			$this->standard,
		];

		return implode(' ', $command);
	}

	/**
	 * @param string $commandOutput
	 *
	 * @return Comment[]
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function parse(string $commandOutput): array
	{
		$result = [];

		$regexp = '/(.*):(\d+)\s+(.*)/im';

		$rows = explode(PHP_EOL, $commandOutput);
		foreach ($rows as $row) {
			preg_match_all($regexp, $row, $matches);
			if (! isset($matches[0][0])) {
				continue;
			}

			$commented = new CommentedFile(new File($matches[1][0]), (int)$matches[2][0]);

			$result[] = new Comment($commented, $matches[3][0]);
		}

		return $result;
	}
}
