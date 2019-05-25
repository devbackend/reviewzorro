<?php

declare(strict_types=1);

namespace ReviewZorro\Integration\Reviewers\Linters\PHP;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpcsChecker;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpmdChecker;
use ReviewZorro\Reviewers\Linters\PHP\PHPLinterReviewer;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PHPLinterReviewerTest extends TestCase
{
	/** @var PHPLinterReviewer */
	private $linter;

	/** @var File[] */
	private $files = [];

	protected function setUp()
	{
		parent::setUp();

		$this->linter = new PHPLinterReviewer();

		$this->linter->addChecker(new PhpcsChecker(PathHelper::path('phpcs.xml')));
		$this->linter->addChecker(new PhpmdChecker(PathHelper::path('phpmd.xml')));

		$this->files = [
			new File(PathHelper::path('examples/tests/PhpLintingClass.php')),
			new File(PathHelper::path('examples/tests/PhpLintingSecondClass.php')),
		];
	}

	public function testReview()
	{
		/** @var Comment[] $comments */
		$comments = $this->linter->review($this->files);

		self::assertCount(8, $comments);

		self::assertEquals($this->files[0]->getPath(), $comments[0]->getCommentedFile()->getFile()->getPath());
		self::assertEquals($this->files[1]->getPath(), $comments[7]->getCommentedFile()->getFile()->getPath());

		self::assertEquals(3, $comments[0]->getCommentedFile()->getLine());
		self::assertEquals(5, $comments[3]->getCommentedFile()->getLine());
		self::assertEquals(6, $comments[5]->getCommentedFile()->getLine());
		self::assertEquals(7, $comments[6]->getCommentedFile()->getLine());

		self::assertStringStartsWith('Each class must be in a namespace', $comments[0]->getText());
		self::assertStringStartsWith('Tabs must be used to indent lines', $comments[3]->getText());
		self::assertStringStartsWith('Avoid unused local variables such as', $comments[5]->getText());
		self::assertStringStartsWith('Avoid unused local variables such as', $comments[6]->getText());
		self::assertStringStartsWith('Opening brace of a class must be on the line', $comments[7]->getText());
	}
}
