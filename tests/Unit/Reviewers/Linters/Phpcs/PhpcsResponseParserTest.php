<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpcs;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsResponseParser;

/**
 * Tests for response parser of phpcs console running.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsResponseParserTest extends TestCase
{
	/** @var File */
	private $file;

	/** @var PhpcsResponseParser */
	private $parser;

	protected function setUp()
	{
		parent::setUp();

		$this->file   = new File('examples/tests/PhpLintingClass.php');
		$this->parser = new PhpcsResponseParser();
	}

	public function testParseShouldReturnArrayOfComments()
	{
		$response = 'FILE: ' . $this->file->getPath() . '
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

		$result = $this->parser->parse($this->file, $response);

		static::assertContainsOnly(Comment::class, $result);
	}

	public function testParseShouldReturnCommentParsedForResponse()
	{
		$response = 'FILE: ' . $this->file->getPath() . '
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

		$result = $this->parser->parse($this->file, $response);

		static::assertCount(5, $result);

		$comment = $result[0];
		static::assertEquals($comment->getText(), 'Each class must be in a namespace of at least one level (a top-level vendor name)');

		$file = $comment->getCommentedFile();
		static::assertEquals($file->getLine(), 3);
		static::assertEquals($this->file, $file->getFile());
	}
}
