<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\ValueObjects;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\CommentedFile;
use ReviewZorro\ValueObjects\FilePath;

/**
 * Tests for CommentedFile value-object.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CommentedFileTest extends TestCase {
	/** @var File */
	private $file;

	protected function setUp() {
		parent::setUp();

		$this->file = new File(
			new FilePath('/foo/bar/filename.php')
		);
	}

	public function testGetters() {
		$commentedFile = new CommentedFile($this->file, 10);

		static::assertEquals($this->file, $commentedFile->getFile());
		static::assertEquals(10, $commentedFile->getLine());
	}
}
