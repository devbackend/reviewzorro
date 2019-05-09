<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Queries;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Queries\FilesQuery;

/**
 * Tests for FilesQuery class.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FilesQueryTest extends TestCase {
	public function testSetterAndGetterForCount() {
		$query = new FilesQuery();

		$actualQuery = $query->setCount(10);
		$result      = $query->getCount();

		static::assertEquals($query, $actualQuery);
		static::assertEquals(10, $result);
	}

	public function testSetterAndGetterForExtension() {
		$query = new FilesQuery();

		$actualQuery = $query->setExtension('php');
		$result      = $query->getExtension();

		static::assertEquals($query, $actualQuery);
		static::assertEquals('php', $result);
	}
}
