<?php

declare(strict_types=1);

namespace ReviewZorro\Contracts;

use Ramsey\Uuid\Uuid;
use ReviewZorro\Entities\File;
use ReviewZorro\Queries\FilesQuery;

/**
 * Repository of files for code review.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface FilesRepositoryInterface
{
    /**
     * @param File $file
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function save(File $file);

    /**
     * @param Uuid $id
     *
     * @return File|null
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function get(Uuid $id): ?File;

    /**
     * @param FilesQuery $query
     *
     * @return File[]
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function getByQuery(FilesQuery $query): array;
}
