<?php

declare(strict_types=1);

namespace ReviewZorro\Services;

use ReviewZorro\Contracts\GitInterface;
use ReviewZorro\Reviewers\ReviewMaster;

/**
 * Service for making code review.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class MakeCodeReview
{
	/** @var GitInterface */
	private $git;

	/** @var ReviewMaster */
	private $master;

	/**
	 * @param GitInterface $changes
	 * @param ReviewMaster $master
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(
		GitInterface $changes,
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
