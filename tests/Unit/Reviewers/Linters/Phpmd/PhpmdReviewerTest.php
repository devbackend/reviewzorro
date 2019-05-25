<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers\Linters\Phpmd;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Entities\File;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdResponseParser;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdReviewer;
use ReviewZorro\Reviewers\Linters\Phpmd\PhpmdRunner;

/**
 * Tests for PhpmdReviewer.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdReviewerTest extends MockeryTestCase
{
	public function testReviewShouldCallRunnerAndParser()
	{
		$file = new File('/foo/bar/path');

		$response = $file->getPath() . ':6	Avoid unused local variables such as $a.';

		$runner = Mockery::mock(PhpmdRunner::class);
		$runner->shouldReceive('run')->withArgs([$file->getPath(), null])->andReturn($response);

		$parser = Mockery::mock(PhpmdResponseParser::class);
		$parser->shouldReceive('parse')->withArgs([$file, $response]);

		$reviewer = new PhpmdReviewer($runner, $parser);

		$reviewer->review([$file]);
	}
}
