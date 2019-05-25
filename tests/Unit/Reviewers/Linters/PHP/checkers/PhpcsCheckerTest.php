<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\PHP\checkers;

use Exception;
use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;
use ReviewZorro\Reviewers\Linters\PHP\Checkers\PhpcsChecker;

/**
 * Tests for Phpcs file checker.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsCheckerTest extends TestCase
{
	public function testGetCommandShouldReturnCommandForRunPhpcsOverFile()
	{
		$standard = PathHelper::path('phpcs.xml');
		$phpcs    = PathHelper::path('vendor', 'bin', 'phpcs');
		$file     = new File('/foo/bar/baz.php');

		$checker = new PhpcsChecker();
		$result  = $checker->getCommand($file);

		static::assertEquals(
			$phpcs . ' --extensions=php --standard=' . $standard . ' ' . $file->getPath(),
			$result
		);
	}

	public function testGetCommandShouldReturnCommandForRunPhpcsOverFileWithPassedStandardFile()
	{

		$standard = './my-phpcs.xml';
		$phpcs    = PathHelper::path('vendor', 'bin', 'phpcs');
		$file     = new File('/foo/bar/baz.php');

		$checker = new PhpcsChecker($standard);
		$result  = $checker->getCommand($file);

		static::assertEquals(
			$phpcs . ' --extensions=php --standard=' . $standard . ' ' . $file->getPath(),
			$result
		);
	}

	public function testParseShouldReturnCommentParsedFromOutput()
	{
		$file   = new File('/foo/bar/baz.php');
		$output = 'FILE: ' . $file->getPath() . '
---------------------------------------------------------------------------------------------------
FOUND 5 ERRORS AFFECTING 3 LINES
---------------------------------------------------------------------------------------------------
 3 | ERROR | [ ] Each class must be in a namespace of at least one level (a top-level vendor name)
 3 | ERROR | [x] Opening brace of a class must be on the line after the definition
 4 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Closing brace must be on a line by itself
---------------------------------------------------------------------------------------------------
PHPCBF CAN FIX THE 4 MARKED SNIFF VIOLATIONS AUTOMATICALLY
---------------------------------------------------------------------------------------------------

Time: 32ms; Memory: 6Mb
';

		$checker = new PhpcsChecker();
		$result  = $checker->parse($output);

		static::assertContainsOnly(Comment::class, $result);
		static::assertCount(5, $result);

		$comment = $result[0];
		static::assertEquals($comment->getText(), 'Each class must be in a namespace of at least one level (a top-level vendor name)');

		static::assertEquals($comment->getCommentedFile()->getLine(), 3);
		static::assertEquals($comment->getCommentedFile()->getFile()->getPath(), $file->getPath());
	}

	public function testParseShouldReturnCommentParsedFromOutputCaseForTwoFiles()
	{
		$firstFile  = new File('/foo/bar/baz1.php');
		$secondFile = new File('/foo/bar/baz2.php');

		$output = '
FILE: ' . $firstFile->getPath() . '
-----------------------------------------------------------------------------------
FOUND 1 ERROR AFFECTING 1 LINE
-----------------------------------------------------------------------------------
 5 | ERROR | [x] Opening brace of a class must be on the line after the definition
-----------------------------------------------------------------------------------
PHPCBF CAN FIX THE 1 MARKED SNIFF VIOLATIONS AUTOMATICALLY
-----------------------------------------------------------------------------------


FILE: ' . $secondFile->getPath() . '
---------------------------------------------------------------------------------------------------
FOUND 5 ERRORS AFFECTING 4 LINES
---------------------------------------------------------------------------------------------------
 3 | ERROR | [ ] Each class must be in a namespace of at least one level (a top-level vendor name)
 3 | ERROR | [x] Opening brace of a class must be on the line after the definition
 4 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 8 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
---------------------------------------------------------------------------------------------------
PHPCBF CAN FIX THE 4 MARKED SNIFF VIOLATIONS AUTOMATICALLY
---------------------------------------------------------------------------------------------------

Time: 33ms; Memory: 6Mb
';

		$checker = new PhpcsChecker();
		$result  = $checker->parse($output);

		static::assertContainsOnly(Comment::class, $result);
		static::assertCount(6, $result);

		$comment = $result[0];
		static::assertStringStartsWith('Opening brace of a class must be on the line', $comment->getText());
		static::assertEquals(5, $comment->getCommentedFile()->getLine());
		static::assertEquals($firstFile->getPath(), $comment->getCommentedFile()->getFile()->getPath());

		$comment = $result[1];
		static::assertStringStartsWith('Each class must be in a namespace', $comment->getText());
		static::assertEquals(3, $comment->getCommentedFile()->getLine());
		static::assertEquals($secondFile->getPath(), $comment->getCommentedFile()->getFile()->getPath());
	}

	/**
	 * @expectedException Exception
	 */
	public function testParseShouldThrowExceptionIfFileNotDetected()
	{
		$output = '
---------------------------------------------------------------------------------------------------
FOUND 5 ERRORS AFFECTING 3 LINES
---------------------------------------------------------------------------------------------------
 3 | ERROR | [ ] Each class must be in a namespace of at least one level (a top-level vendor name)
 3 | ERROR | [x] Opening brace of a class must be on the line after the definition
 4 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Closing brace must be on a line by itself
---------------------------------------------------------------------------------------------------
PHPCBF CAN FIX THE 4 MARKED SNIFF VIOLATIONS AUTOMATICALLY
---------------------------------------------------------------------------------------------------

Time: 32ms; Memory: 6Mb
';

		$checker = new PhpcsChecker();
		$checker->parse($output);
	}
}
