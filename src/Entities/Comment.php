<?php

declare(strict_types=1);

namespace ReviewZorro\Entities;

use InvalidArgumentException;
use ReviewZorro\ValueObjects\CommentedFile;

/**
 * Entity for reviewing comments.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class Comment
{
	/** @var CommentedFile */
	private $commentedFile;

	/** @var string */
	private $text;

	/**
	 * @param CommentedFile $commentedFile
	 * @param string        $text
	 *
	 * @throws InvalidArgumentException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function __construct(CommentedFile $commentedFile, string $text)
	{
		if ('' === $text) {
			throw new InvalidArgumentException('Comment text can\'t be empty');
		}

		$this->commentedFile = $commentedFile;
		$this->text          = $text;
	}

	/**
	 * @return CommentedFile
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getCommentedFile(): CommentedFile
	{
		return $this->commentedFile;
	}

	/**
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getText(): string
	{
		return $this->text;
	}
}
