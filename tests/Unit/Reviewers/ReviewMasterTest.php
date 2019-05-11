<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Contracts\ReviewerInterface;
use ReviewZorro\Reviewers\ReviewMaster;

/**
 * Tests for ReviewMaster component.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class ReviewMasterTest extends MockeryTestCase
{
	public function testReview()
	{
		$reviewer = Mockery::spy(ReviewerInterface::class);
		$reviewer->shouldReceive('review')->andReturn([]);

		$files  = [];
		$master = new ReviewMaster([$reviewer]);
		$master->review($files);

		$reviewer->shouldHaveReceived('review', [$files]);
	}
}
