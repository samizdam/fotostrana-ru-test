<?php

namespace Samizdam\Fotostrana\Task3;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TextFileIteratorTest extends \PHPUnit_Framework_TestCase
{
    const DS = DIRECTORY_SEPARATOR;
    const SMALL_TEST_FILEPATH = __DIR__ . self::DS . 'files' . self::DS . 'foo.txt';
    const BIG_TEST_FILEPATH = __DIR__ . self::DS . 'files' . self::DS . '2GB.txt';

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

    public function testSeekOutOfRangeException()
    {
        $iterator = new TextFileCharIterator(self::SMALL_TEST_FILEPATH);
        $this->expectException(\OutOfRangeException::class);
        $iterator->seek(100500);
    }

    public function testSeekIn2GBFile()
    {
        if(!file_exists(self::BIG_TEST_FILEPATH)) {
            $this->markTestSkipped('2GB.txt for this test not exists. You can create it with generate-2GB-file.sh ');
        }
        $iterator = new TextFileCharIterator(self::BIG_TEST_FILEPATH);
        $twoGB = 1024 * 1024 * 1024 * 2;
        $iterator->seek($twoGB - 1);
        $this->assertTrue($iterator->valid());
        $this->expectException(\OutOfRangeException::class);
        $iterator->seek($twoGB);
    }
}