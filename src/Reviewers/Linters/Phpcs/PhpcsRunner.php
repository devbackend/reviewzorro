<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\Phpcs;

use ReviewZorro\Helpers\PathHelper;

/**
 * Component for phpcs console run over file.
 *
 * @author Кривонос Иван <krivonos.iv@dns-shop.ru>
 */
class PhpcsRunner
{
	public function run(string $filename): string
	{
		$command = [
			PathHelper::path('vendor/bin/phpcs'),
			'--extensions=php',
			'--standard=' . PathHelper::path('phpcs.xml'),
			$filename,
		];

		exec(implode(' ', $command), $result);

		return implode("\n", $result);
	}
}
