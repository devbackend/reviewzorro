<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\File;

/**
 * Tests for File entity.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FileTest extends TestCase
{
	public function testGetters()
	{
		$path = '/foo/bar/filename.php';
		$file = new File($path);

		static::assertEquals($path, $file->getPath());
		static::assertEquals('php', $file->getExtension());
		static::assertEquals('filename.php', $file->getName());
		static::assertEquals('filename', $file->getName(false));
	}

	public function testShouldThrowExceptionOnEmptyFileName()
	{
		$this->expectException(InvalidArgumentException::class);
		new File('');
	}

	public function testShouldReturnNullForExtensionIfNotExists()
	{
		$file = new File('/foo/bar');

		$result = $file->getExtension();

		static::assertNull($result);
	}

	public function testEqualsGetNameForFilenameWithoutExtension()
	{
		$file = new File('/foo/bar');

		static::assertEquals($file->getName(), $file->getName(false));
	}
}
