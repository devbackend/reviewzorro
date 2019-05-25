<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpcs;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Entities\File;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsResponseParser;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsReviewer;
use ReviewZorro\Reviewers\Linters\Phpcs\PhpcsRunner;

/**
 * Tests for Phpcs reviewer.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpcsReviewerTest extends MockeryTestCase
{

	public function testReviewShouldCallRunnerAndParser()
	{
		$file     = new File('/foo/bar/path');
		$response = 'FILE: ' . $file->getPath() . '
---------------------------------------------------------------------------------------------------
FOUND 5 ERRORS AFFECTING 3 LINES
---------------------------------------------------------------------------------------------------
 3 | ERROR | [ ] Each class must be in a namespace of at least one level (a top-level vendor name)
---------------------------------------------------------------------------------------------------
PHPCBF CAN FIX THE 4 MARKED SNIFF VIOLATIONS AUTOMATICALLY
---------------------------------------------------------------------------------------------------

Time: 32ms; Memory: 6Mb
';

		$runner = Mockery::mock(PhpcsRunner::class);
		$runner->shouldReceive('run')->withArgs([$file->getPath(), null])->andReturn($response);

		$parser = Mockery::mock(PhpcsResponseParser::class);
		$parser->shouldReceive('parse')->withArgs([$file, $response]);

		$reviewer = new PhpcsReviewer($runner, $parser);

		$reviewer->review([$file]);
	}
}
