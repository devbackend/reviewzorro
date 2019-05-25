<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\PHP;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpFileChecker;
use ReviewZorro\Reviewers\Linters\PHP\PHPLinterReviewer;

/**
 * Tests for PHP files linter.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpLinterReviewerTest extends MockeryTestCase
{
	/** @var PHPLinterReviewer */
	private $linter;

	/** @var PhpFileChecker|MockInterface $checker */
	private $checker;

	protected function setUp()
	{
		parent::setUp();

		$this->linter  = new PHPLinterReviewer();
		$this->checker = Mockery::mock(PhpFileChecker::class);

		$this->linter->addChecker($this->checker);

		$this->checker->shouldReceive('getCommand')->withAnyArgs()->andReturnUsing(function (File $file) {
			return 'cat /dev/null #' . $file->getPath();
		});

		$this->checker->shouldReceive('parse')->withAnyArgs();
	}

	public function testReviewShouldReturnArrayOfComments()
	{
		$result = $this->linter->review([new File('/foo/bar/baz.php')]);

		static::assertContainsOnly(Comment::class, $result);
	}

	public function testReviewShouldNotReturnCommentsForNonPhpFiles()
	{
		$result = $this->linter->review([new File('/foo/bar/baz.js')]);

		static::assertEmpty($result);
	}

	public function testReviewShouldCallCheckerOverPhpFiles()
	{
		$file = new File(PathHelper::path('examples/tests/PhpLintingClass.php'));

		$this->linter->review([$file]);

		$this->checker->shouldHaveReceived('getCommand');
		$this->checker->shouldHaveReceived('parse');
	}
}
