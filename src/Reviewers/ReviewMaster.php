<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers;

use ReviewZorro\Components\Collection;
use ReviewZorro\Contracts\ReviewerInterface;
use ReviewZorro\Entities\Comment;

/**
 * Master of code review; contain collection of reviewers and pass files to it.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
final class ReviewMaster implements ReviewerInterface
{
	/** @var Collection<ReviewerInterface> */
	private $reviewers = [];

	/**
	 * @param ReviewerInterface[] $reviewers
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(array $reviewers)
	{
		$this->reviewers = new Collection($reviewers, ReviewerInterface::class);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function review(Collection $files): Collection
	{
		$result = new Collection([], Comment::class);
		foreach ($this->reviewers as $reviewer) {
			$result->merge($reviewer->review($files), true);
		}

		return $result;
	}
}
