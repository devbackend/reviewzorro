<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\FilePath;

/**
 * Tests for File entity.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FileTest extends TestCase {
	public function testGetters() {
		$path = new FilePath('/foo/bar/filename.php');
		$file = new File($path);

		static::assertEquals($path, $file->getPath());
	}

}
