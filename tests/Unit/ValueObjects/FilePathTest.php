<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\ValueObjects\FilePath;

/**
 * Tests for filePath value-object.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FilePathTest extends TestCase {
	const FILE_PATH = '/foo/bar/filename.php';

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testShouldThrowExceptionOnEmptyFileName() {
		new FilePath('');
	}

	public function testFilePathToString() {
		$path = new FilePath(static::FILE_PATH);

		$result = (string)$path;

		static::assertEquals(static::FILE_PATH, $result);
	}

	public function testGetters() {
		$path = new FilePath(static::FILE_PATH);

		static::assertEquals('php', $path->getExtension());
		static::assertEquals('filename.php', $path->getName());
		static::assertEquals('filename', $path->getName(false));
	}

	public function testShouldReturnNullForExtensionIfNotExists() {
		$path = new FilePath('/foo/bar');

		$result = $path->getExtension();

		static::assertNull($result);
	}

	public function testEqualsGetNameForFilenameWithoutExtension() {
		$path = new FilePath('/foo/bar');
		
		static::assertEquals($path->getName(), $path->getName(false));
	}
}
