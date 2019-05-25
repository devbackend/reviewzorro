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
	public function run(string $filename, ?string $standard = null): string
	{
		$standard = $standard ?? PathHelper::path('phpcs.xml');

		$command = [
			PathHelper::path('vendor/bin/phpcs'),
			'--extensions=php',
			'--standard=' . $standard,
			$filename,
		];

		exec(implode(' ', $command), $result);

		return implode(PHP_EOL, $result);
	}
}
