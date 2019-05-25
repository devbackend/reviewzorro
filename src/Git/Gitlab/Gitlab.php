<?php

declare(strict_types=1);

namespace ReviewZorro\Git\Gitlab;

use Gitlab\Client;
use ReviewZorro\Contracts\GitInterface;
use ReviewZorro\Entities\Comment;
use ReviewZorro\Entities\File;
use ReviewZorro\Helpers\PathHelper;

/**
 * Class for work with Gitlab.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class Gitlab implements GitInterface
{
	/** @var Client */
	private $client;

	/** @var MergeRequest */
	private $request;

	/** @var File[] */
	private $files = [];

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function loadRequest(int $projectId, int $requestId)
	{
		$changes = $this->client->merge_requests->changes($projectId, $requestId);

		$this->request            = new MergeRequest($requestId);
		$this->request->projectId = $projectId;
		$this->request->sha       = $changes['sha'];
		$this->request->baseSha   = $changes['diff_refs']['base_sha'];
		$this->request->headSha   = $changes['diff_refs']['head_sha'];
		$this->request->startSha  = $changes['diff_refs']['start_sha'];

		$this->files = [];
		foreach ($changes['changes'] as $change) {
			$gitFilePath = $change['new_path'];

			$filePath = PathHelper::path('tmp', $this->request->sha, $gitFilePath);
			$fileDir  = dirname($filePath);

			if (false === file_exists($fileDir)) {
				mkdir($fileDir, 0777, true);
			}

			$rawFile = $this->client->repositoryFiles()->getRawFile($projectId, $gitFilePath, $this->request->sha);

			file_put_contents($filePath, $rawFile);

			$this->files[$gitFilePath] = new File($filePath);
		}
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getFiles(): array
	{
		return $this->files;
	}

	/**
	 * @param Comment[] $comments
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function send(array $comments)
	{
		$files = [];
		foreach ($this->files as $gitPath => $file) {
			$files[$file->getPath()] = $gitPath;
		}

		foreach ($comments as $comment) {
			$this->client->merge_requests->addDiscussion($this->request->projectId, $this->request->id, [
				'body' => $comment->getText(),
				'position' => [
					'base_sha'      => $this->request->baseSha,
					'head_sha'      => $this->request->headSha,
					'start_sha'     => $this->request->startSha,
					'position_type' => 'text',
					'new_path'      => $files[$comment->getCommentedFile()->getFile()->getPath()],
					'new_line'      => $comment->getCommentedFile()->getLine(),
				]
			]);
		}
	}
}
