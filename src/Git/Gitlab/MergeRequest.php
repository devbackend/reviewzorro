<?php

declare(strict_types=1);

namespace ReviewZorro\Git\Gitlab;

/**
 * Class for describe Gitlab diff refs.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class MergeRequest
{
	/** @var int */
	public $id;

	/** @var int */
	public $projectId;

	/** @var string */
	public $sha;

	/** @var string */
	public $baseSha;

	/** @var string */
	public $headSha;

	/** @var string */
	public $startSha;

	/**
	 * @param int $id Request id
	 *
	 * @author Кривонос Иван <krivonos.iv@dns-shop.ru>
	 */
	public function __construct(int $id)
	{
		$this->id = $id;
	}
}
