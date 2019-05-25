<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\PHP\checkers;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpmdChecker;

/**
 * Tests for Phpmd file checker.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdCheckerTest extends TestCase
{
	public function testGetCommandShouldReturnCommandForRunPhpcsOverFile()
	{
		$standard = PathHelper::path('phpmd.xml');
		$phpmd    = PathHelper::path('vendor', 'bin', 'phpmd');
		$file     = new File('/foo/bar/baz.php');

		$checker = new PhpmdChecker();
		$result  = $checker->getCommand($file);

		static::assertEquals(
			$phpmd . ' ' . $file->getPath() . ' text ' . $standard,
			$result
		);
	}
	public function testGetCommandShouldReturnCommandForRunPhpcsOverFileWithPassedStandardFile()
	{
		$standard = PathHelper::path('my-phpmd.xml');
		$phpmd    = PathHelper::path('vendor', 'bin', 'phpmd');
		$file     = new File('/foo/bar/baz.php');

		$checker = new PhpmdChecker($standard);
		$result  = $checker->getCommand($file);

		static::assertEquals(
			$phpmd . ' ' . $file->getPath() . ' text ' . $standard,
			$result
		);
	}

	public function testParseShouldReturnArrayOfComments()
	{
		$file     = new File('/foo/bar/baz.php');
		$response = $file->getPath() . ':6	Avoid unused local variables such as \'$a\'.';

		$checker = new PhpmdChecker();
		$result  = $checker->parse($response);

		static::assertContainsOnly(Comment::class, $result);
		static::assertCount(1, $result);

		$comment = $result[0];
		static::assertStringStartsWith('Avoid unused local variables', $comment->getText());

		static::assertEquals(6, $comment->getCommentedFile()->getLine());
		static::assertEquals($file->getPath(), $comment->getCommentedFile()->getFile()->getPath());
	}
}
