<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\Phpmd;

use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\CommentedFile;

/**
 * Parser for response of console run Phpmd.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdResponseParser
{
	/**
	 * @param File   $file     Linted file
	 * @param string $response Response from phpmd
	 *
	 * @return Comment[]
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function parse(File $file, string $response): array
	{
		$result = [];

		$regexp = '/.*:(\d+)\s+(.*)/im';

		$rows = explode(PHP_EOL, $response);
		foreach ($rows as $row) {
			preg_match_all($regexp, $row, $matches);
			if (! isset($matches[0][0])) {
				continue;
			}

			$commented = new CommentedFile($file, (int)$matches[1][0]);

			$result[] = new Comment($commented, $matches[2][0]);
		}

		return $result;
	}
}
