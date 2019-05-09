<?php

declare(strict_types=1);

namespace ReviewZorro\Services;

use ReviewZorro\Contracts\GitInterfaces;
use ReviewZorro\Reviewers\ReviewMaster;

/**
 * Service for making code review.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class MakeCodeReview
{
	/** @var GitInterfaces */
	private $git;

	/** @var ReviewMaster */
	private $master;

	/**
	 * @param GitInterfaces $changes
	 * @param ReviewMaster  $master
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(
		GitInterfaces $changes,
		ReviewMaster $master
	) {
		$this->git    = $changes;
		$this->master = $master;
	}

	/**
	 * Main method for code review making.
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function run()
	{
		$files    = $this->git->getFiles();
		$comments = $this->master->review($files);

		$this->git->send($comments);
	}
}
