<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Entities;

use Ramsey\Uuid\Uuid;
use ReviewZorro\Entities\File;
use ReviewZorro\ValueObjects\FilePath;

/**
 * @coversDefaultClass \ReviewZorro\Entities\File
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FileTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @covers ::getId
	 * @covers ::getPath
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testGetters() {
		$id   = Uuid::uuid4();
		$path = new FilePath('/foo/bar/filename.php');
		$file = new File($id, $path);

		static::assertEquals($id, $file->getId());
		static::assertEquals($path, $file->getPath());
	}

}
