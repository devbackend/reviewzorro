<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Helpers\PathHelper;

/**
 * Tests for PathHelper.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PathHelperTest extends TestCase
{
	/** @var string */
	private $root;

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->root = dirname(dirname(dirname(__DIR__)));
	}

	public function testRootShouldReturnRootPathOfApp()
	{
		static::assertEquals($this->root, PathHelper::root());
	}

	public function testPathShouldReturnAbsolutePathForRelativeParam()
	{
		static::assertEquals($this->root . '/tests', PathHelper::path('tests'));
	}

	public function testPathShouldReturnRootPathForEmptyRelative()
	{
		static::assertEquals($this->root, PathHelper::path(''));
	}

	public function testPathShouldReturnJoinedDirectoryParamForAbsolutePath()
	{
		static::assertEquals($this->root . '/tests/unit', PathHelper::path('tests', 'unit'));
	}
}
