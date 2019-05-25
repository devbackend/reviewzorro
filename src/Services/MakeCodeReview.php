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
	private $reviewer;

	/**
	 * @param GitInterface $git
	 * @param ReviewMaster $reviewer
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(
		GitInterface $git,
		ReviewMaster $reviewer
	) {
		$this->git      = $git;
		$this->reviewer = $reviewer;
	}

	/**
	 * Main method for code review making.
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function run()
	{
		$files    = $this->git->getFiles();
		$comments = $this->reviewer->review($files);

		$this->git->send($comments);
	}
}
