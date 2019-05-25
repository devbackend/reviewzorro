<?php

declare(strict_types=1);

namespace ReviewZorro\Reviewers\Linters\Phpmd;

use ReviewZorro\Contracts\ReviewerInterface;

/**
 * Implementation Phpmd reviewer.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PhpmdReviewer implements ReviewerInterface
{
	/** @var PhpmdRunner */
	private $runner;

	/** @var PhpmdResponseParser */
	private $parser;

	/** @var string */
	private $standard;

	public function __construct(PhpmdRunner $runner, PhpmdResponseParser $parser)
	{
		$this->runner = $runner;
		$this->parser = $parser;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function review(array $files): array
	{
		$result = [];
		foreach ($files as $file) {
			$result = array_merge($result, $this->parser->parse($file, $this->runner->run($file->getPath(), $this->standard)));
		}

		return $result;
	}

	/**
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getStandard(): string
	{
		return $this->standard;
	}

	/**
	 * @param string $standard
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function setStandard(string $standard)
	{
		$this->standard = $standard;
	}
}
