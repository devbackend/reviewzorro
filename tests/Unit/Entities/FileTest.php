<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\FilePath;

/**
 * Tests for File entity.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FileTest extends TestCase {
	public function testGetters() {
		$id   = Uuid::uuid4();
		$path = new FilePath('/foo/bar/filename.php');
		$file = new File($id, $path);

		static::assertEquals($id, $file->getId());
		static::assertEquals($path, $file->getPath());
	}

}
