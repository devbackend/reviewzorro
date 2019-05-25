<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\PHP\Checkers;

use Exception;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\ValueObjects\CommentedFile;

/**
 * Phpcs file checker.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsChecker implements PhpFileChecker
{
	/** @var string|null */
	private $standard;

	public function __construct(?string $standard = null)
	{
		$this->standard = $standard ?? PathHelper::path('phpcs.xml');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getCommand(File $file): string
	{
		$command = [
			PathHelper::path('vendor', 'bin', 'phpcs'),
			'--extensions=php',
			'--standard=' . $this->standard,
			$file->getPath(),
		];

		return implode(' ', $command);
	}

	/**
	 * @param string $commandOutput
	 *
	 * @return Comment[]
	 *
	 * @throws Exception
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function parse(string $commandOutput): array
	{
		$result = [];

		$fileRegexp    = '/FILE: (\S+)/im';
		$commentRegexp = '/(\d+)\s+\|\s+\w+\s\|\s+\[[^]]]\s+(.*)/im';

		$file = null;
		$rows = explode(PHP_EOL, $commandOutput);
		foreach ($rows as $row) {
			preg_match_all($fileRegexp, $row, $matches);
			if (isset($matches[1][0])) {
				$file = new File($matches[1][0]);
			}

			preg_match_all($commentRegexp, $row, $matches);
			if (! isset($matches[0][0])) {
				continue;
			}

			if (null === $file) {
				throw new Exception('Reviewed file not defined!');
			}

			$commented = new CommentedFile($file, (int)$matches[1][0]);
			$result[]  = new Comment($commented, $matches[2][0]);
		}

		return $result;
	}
}
