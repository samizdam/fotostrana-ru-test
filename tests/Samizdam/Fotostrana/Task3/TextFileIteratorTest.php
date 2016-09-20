<?php

namespace Samizdam\Fotostrana\Task3;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TextFileIteratorTest extends \PHPUnit_Framework_TestCase
{

    const SMALL_TEST_FILEPATH = __DIR__ . DIRECTORY_SEPARATOR . 'foo.txt';

    public function testZeroPositionOnOpenedFile()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $this->assertSame(0, $iterator->key());
    }

    public function testZeroPositionChar()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $this->assertSame('0', $iterator->current());
    }

    public function testNextCharRead()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $iterator->next();
        $this->assertSame('1', $iterator->current());
    }

    public function testRewind()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $iterator->next();
        $iterator->rewind();
        $this->assertSame(0, $iterator->key());
    }

    public function testSeek()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $iterator->seek(10);
        $this->assertSame('A', $iterator->current());
    }

    public function testForeach()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        foreach ($iterator as $i => $char) {
            /** empty each */
        }
        $this->assertSame($i, 11);
    }

    public function testSeekOutOf___Exception()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $this->expectException(\OutOfRangeException::class);
        $iterator->seek(100500);
    }
}