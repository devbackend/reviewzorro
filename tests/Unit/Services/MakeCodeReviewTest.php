<?php

declare(strict_types=1);

namespace ReviewZorro\Unit\Services;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReviewZorro\Contracts\GitInterfaces;
use ReviewZorro\Reviewers\ReviewMaster;
use ReviewZorro\Services\MakeCodeReview;

/**
 * @coversDefaultClass \ReviewZorro\Services\MakeCodeReview
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class MakeCodeReviewTest extends MockeryTestCase
{
	/**
	 * @covers ::run
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function testRunMethod()
	{
		$git    = Mockery::spy(GitInterfaces::class);
		$master = new ReviewMaster([]);

		$service = new MakeCodeReview($git, $master);
		$service->run();

		$git->shouldHaveReceived('send');
	}

}
