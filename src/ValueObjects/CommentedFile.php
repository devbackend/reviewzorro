<?php

declare(strict_types=1);

namespace ReviewZorro\ValueObjects;

use ReviewZorro\Entities\File;

/**
 * Value object for commented file.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class CommentedFile
{
    /** @var File */
    private $file;

    /** @var int */
    private $line;

    public function __construct(File $file, int $line)
    {
        $this->file = $file;
        $this->line = $line;
    }

    /**
     * @return File
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @return int
     *
     * @author Ivan Krivonos <devbackend@yandex.ru>
     */
    public function getLine(): int
    {
        return $this->line;
    }
}
