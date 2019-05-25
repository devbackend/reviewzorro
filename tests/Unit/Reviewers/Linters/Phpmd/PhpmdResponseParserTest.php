<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpmd;

use PHPUnit\Framework\TestCase;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdResponseParser;

/**
 * Tests for PhpmdResponseParser.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdResponseParserTest extends TestCase
{
	/** @var File */
	private $file;

	/** @var PhpmdResponseParser */
	private $parser;

	protected function setUp()
	{
		parent::setUp();

		$this->file   = new File('examples/tests/PhpLintingClass.php');
		$this->parser = new PhpmdResponseParser();
	}

	public function testParseShouldReturnArrayOfComments()
	{
		$response = $this->file->getPath() . ':6	Avoid unused local variables such as \'$a\'.';

		$result = $this->parser->parse($this->file, $response);

		static::assertContainsOnly(Comment::class, $result);
	}

	public function testParseShouldReturnCommentParsedForResponse()
	{
		$response = $this->file->getPath() . ':6	Avoid unused local variables such as $a';

		$result = $this->parser->parse($this->file, $response);

		static::assertCount(1, $result);

		$comment = $result[0];
		static::assertEquals($comment->getText(), 'Avoid unused local variables such as $a');

		$file = $comment->getCommentedFile();
		static::assertEquals($file->getLine(), 6);
		static::assertEquals($this->file, $file->getFile());
	}
}
