<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\Phpmd;

use ReviewZorro\Helpers\PathHelper;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdRunner
{
	/**
	 * @param string      $filePath
	 * @param string|null $standard
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function run(string $filePath, ?string $standard = null): string
	{
		$standard = $standard ?? PathHelper::path('phpmd.xml');

		$command = [
			PathHelper::path('vendor/bin/phpmd'),
			$filePath,
			'text',
			$standard,
		];

		exec(implode(' ', $command), $result);

		return implode(PHP_EOL, $result);
	}
}
