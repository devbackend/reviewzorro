<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\CommentedFile;

/**
 * Tests for Commecnt entity.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CommentTest extends TestCase
{
	private const MESSAGE = 'Message text';

	/** @var File */
	private $file;

	protected function setUp(): void
	{
		parent::setUp();

		$this->file = new File('/foo/bar/filename.php');
	}

	public function testGetters()
	{
		$commentedFile = new CommentedFile($this->file, 10);
		$comment       = new Comment($commentedFile, static::MESSAGE);

		static::assertEquals($commentedFile, $comment->getCommentedFile());
		static::assertEquals(static::MESSAGE, $comment->getText());
	}

	public function testShouldThrowExceptionOnEmptyMessage()
	{
		$this->expectException(InvalidArgumentException::class);
		new Comment(
			new CommentedFile($this->file, 10),
			''
		);
	}
}
