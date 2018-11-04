<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Reviewers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Components\Collection;
use ReviewZorro\Contracts\ReviewerInterface;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Reviewers\ReviewMaster;

/**
 * @coversDefaultClass \ReviewZorro\Reviewers\ReviewMaster
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class ReviewMasterTest extends MockeryTestCase
{
	/**
	 * @covers ::review
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testReview()
	{
		$reviewer = Mockery::spy(ReviewerInterface::class);
		$reviewer->shouldReceive('review')->andReturn(new Collection([], Comment::class));

		$files  = new Collection([], File::class);
		$master = new ReviewMaster([$reviewer]);
		$master->review($files);

		$reviewer->shouldHaveReceived('review', [$files]);
	}
}