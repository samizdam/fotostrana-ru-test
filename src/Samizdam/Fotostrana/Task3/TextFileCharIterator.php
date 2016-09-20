<?php

namespace Samizdam\Fotostrana\Task3;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TextFileCharIterator implements \SeekableIterator
{

    private $filename;
    private $resource;
    private $filesize;

    public function __construct(string $filename)
    {
        if (file_exists($filename)) {
            $this->filename = $filename;
            $this->resource = fopen($this->filename, 'r');
            $this->filesize = filesize($this->filename);
        } else {
            throw new \RuntimeException('File ' . $filename . ' not found. ');
        }
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return fgetc($this->resource);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        fseek($this->resource, 1, SEEK_CUR);
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return ftell($this->resource);
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->key() < $this->filesize;
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        rewind($this->resource);
    }

    /**
     * Seeks to a position
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @param int $position <p>
     * The position to seek to.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function seek($position)
    {
        fseek($this->resource, $position, SEEK_SET);
        if (!$this->valid()) {
            throw new \OutOfRangeException('Seek out of file content. ');
        }
    }
}