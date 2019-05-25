<?php

declare(strict_types=1);

namespace ReviewZorro\Integration\Reviewers;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdResponseParser;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdReviewer;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdRunner;

/**
 * Integration tests of Phpmd Reviewer.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdReviewerTest extends TestCase
{
	/** @var PhpmdReviewer */
	private $reviewer;

	protected function setUp()
	{
		parent::setUp();

		$this->reviewer = new PhpmdReviewer(
			new PhpmdRunner(),
			new PhpmdResponseParser()
		);
	}

	public function testRunWithRealPhpmdReviewer()
	{
		$first  = new File(PathHelper::path('examples/tests/PhpLintingClass.php'));
		$second = new File(PathHelper::path('examples/tests/PhpLintingSecondClass.php'));

		/** @var Comment[] $comments */
		$comments = $this->reviewer->review([$first, $second]);

		self::assertCount(2, $comments);

		self::assertEquals($first->getPath(), $comments[0]->getCommentedFile()->getFile()->getPath());
		self::assertEquals(6, $comments[0]->getCommentedFile()->getLine());
		self::assertStringStartsWith('Avoid unused local variables such as', $comments[0]->getText());

		self::assertEquals($first->getPath(), $comments[1]->getCommentedFile()->getFile()->getPath());
		self::assertEquals(7, $comments[1]->getCommentedFile()->getLine());
		self::assertStringStartsWith('Avoid unused local variables such as', $comments[1]->getText());
	}
}
