<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers;

use ReviewZorro\Contracts\ReviewerInterface;

/**
 * Master of code review; contain collection of reviewers and pass files to it.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
final class ReviewMaster implements ReviewerInterface
{
	/** @var ReviewerInterface[] */
	private $reviewers = [];

	/**
	 * @param ReviewerInterface[] $reviewers
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(array $reviewers)
	{
		$this->reviewers = $reviewers;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function review(array $files): array
	{
		$result = [];
		foreach ($this->reviewers as $reviewer) {
			$result = array_merge($result, $reviewer->review($files));
		}

		return $result;
	}
}
