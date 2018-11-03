<?php

namespace ReviewZorro\Contracts;

use ReviewZorro\Components\Collection;

/**
 * Reviewer for file.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface ReviewerInterface
{
    /**
     * @param Collection<File> $files
     *
     * @return Collection<Comment>
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function review(Collection $files): Collection;
}
