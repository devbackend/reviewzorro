<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpcs;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsRunner;

/**
 * Tests for Phpcs console runner.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsRunnerTest extends MockeryTestCase
{
	public function testRun()
	{
		$filePath = PathHelper::path('examples/tests/PhpcsLintingClass.php');

		$runner = new PhpcsRunner();

		$result = $runner->run($filePath);

		static::assertContains('FILE: ' . $filePath, $result);
	}
}
