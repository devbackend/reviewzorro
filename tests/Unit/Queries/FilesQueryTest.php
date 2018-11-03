<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Queries;

use ReviewZorro\Queries\FilesQuery;

/**
 * @coversDefaultClass \ReviewZorro\Queries\FilesQuery
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class FilesQueryTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @covers ::setCount
	 * @covers ::getCount
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
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
