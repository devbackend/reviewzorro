<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Services;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Contracts\GitInterface;
use ReviewZorro\Reviewers\ReviewMaster;
use ReviewZorro\Services\MakeCodeReview;

/**
 * Tests for code review service.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class MakeCodeReviewTest extends MockeryTestCase
{
	public function testRunMethod()
	{
		$git    = Mockery::spy(GitInterface::class);
		$master = new ReviewMaster([]);

		$service = new MakeCodeReview($git, $master);
		$service->run();

		$git->shouldHaveReceived('send');
	}
}
