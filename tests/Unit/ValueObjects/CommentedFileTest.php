<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\ValueObjects;

use Ramsey\Uuid\Uuid;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\CommentedFile;
use ReviewZorro\ValueObjects\FilePath;

/**
 * @coversDefaultClass \ReviewZorro\ValueObjects\CommentedFile
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CommentedFileTest extends \PHPUnit\Framework\TestCase {
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
	 * @covers ::getFile
	 * @covers ::getLine
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testGetters() {
		$commentedFile = new CommentedFile($this->file, 10);

		static::assertEquals($this->file, $commentedFile->getFile());
		static::assertEquals(10, $commentedFile->getLine());
	}
}
