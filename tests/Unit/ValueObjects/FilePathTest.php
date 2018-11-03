<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\ValueObjects;

use InvalidArgumentException;
use ReviewZorro\ValueObjects\FilePath;

/**
 * @coversDefaultClass \ReviewZorro\ValueObjects\FilePath
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FilePathTest extends \PHPUnit\Framework\TestCase {
	const FILE_PATH = '/foo/bar/filename.php';

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testShouldThrowExceptionOnEmptyFileName() {
		new FilePath('');
	}

	/**
	 * @covers ::__toString
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testFilePathToString() {
		$path = new FilePath(static::FILE_PATH);

		$result = (string)$path;

		static::assertEquals(static::FILE_PATH, $result);
	}

	/**
	 * @covers ::getExtension
	 * @covers ::getName
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testGetters() {
		$path = new FilePath(static::FILE_PATH);

		static::assertEquals('php', $path->getExtension());
		static::assertEquals('filename.php', $path->getName());
		static::assertEquals('filename', $path->getName(false));
	}

	/**
	 * @covers ::getExtension
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
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
