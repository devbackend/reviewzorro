<?php

declare(strict_types=1);

namespace ReviewZorro\Integration\Reviewers;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsResponseParser;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsReviewer;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsRunner;

/**
 * Integration tests of service for making code review.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsReviewerTest extends TestCase
{
	/** @var PhpcsReviewer */
	private $reviewer;

	protected function setUp()
	{
		parent::setUp();

		$this->reviewer = new PhpcsReviewer(new PhpcsRunner(), new PhpcsResponseParser());
	}


	public function testRunWithRealPhpcsReviewer()
	{
		$first  = new File(PathHelper::path('examples/tests/PhpcsLintingClass.php'));
		$second = new File(PathHelper::path('examples/tests/PhpcsLintingSecondClass.php'));

		/** @var Comment[] $comments */
		$comments = $this->reviewer->review([$first, $second]);

		self::assertCount(6, $comments);

		self::assertEquals($first->getPath(), $comments[0]->getCommentedFile()->getFile()->getPath());
		self::assertEquals(3, $comments[0]->getCommentedFile()->getLine());
		self::assertEquals('Each class must be in a namespace of at least one level (a top-level vendor name)', $comments[0]->getText());

		self::assertEquals($first->getPath(), $comments[2]->getCommentedFile()->getFile()->getPath());
		self::assertEquals(4, $comments[2]->getCommentedFile()->getLine());
		self::assertEquals('Tabs must be used to indent lines; spaces are not allowed', $comments[2]->getText());

		self::assertEquals($second->getPath(), $comments[5]->getCommentedFile()->getFile()->getPath());
		self::assertEquals(5, $comments[5]->getCommentedFile()->getLine());
		self::assertEquals('Opening brace of a class must be on the line after the definition', $comments[5]->getText());
	}
}
