<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpmd;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdRunner;

/**
 * Tests for Phpmd runner.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdRunnerTest extends TestCase
{
	public function testRun()
	{
		$filePath = PathHelper::path('examples/tests/PhpLintingClass.php');

		$runner = new PhpmdRunner();

		$result = $runner->run($filePath);

		static::assertContains('examples/tests/PhpLintingClass.php', $result);
	}
}
