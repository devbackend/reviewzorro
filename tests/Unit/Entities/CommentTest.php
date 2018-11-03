<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use Ramsey\Uuid\Uuid;
use ReviewZorro\Entities\File;
use ReviewZorro\Entities\Comment;
use ReviewZorro\ValueObjects\CommentedFile;
use ReviewZorro\ValueObjects\FilePath;

/**
 * @coversDefaultClass \ReviewZorro\Entities\Comment
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CommentTest extends \PHPUnit\Framework\TestCase {
	const MESSAGE = 'Message text';

	/** @var File */
	private $file;

	protected function setUp() {
		parent::setUp();

		$this->file = new File(
			Uuid::uuid4(),
			new FilePath('/foo/bar/filename.php')
		);
	}

	/**
	 * @covers ::getId
	 * @covers ::getCommentedFile
	 * @covers ::getText
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testGetters() {
		$id            = Uuid::uuid4();
		$commentedFile = new CommentedFile($this->file, 10);
		$comment       = new Comment($id, $commentedFile, static::MESSAGE);

		static::assertEquals($id, $comment->getId());
		static::assertEquals($commentedFile, $comment->getCommentedFile());
		static::assertEquals(static::MESSAGE, $comment->getText());
	}

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testShouldThrowExceptionOnEmptyMessage() {
		new Comment(
			Uuid::uuid4(),
			new CommentedFile($this->file, 10),
			''
		);
	}
}
