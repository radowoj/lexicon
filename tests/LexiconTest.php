<?php

namespace Radowoj\Lexicon;

use PHPUnit\Framework\TestCase;
use Radowoj\Lexicon\Trie;

class TrieTest extends TestCase
{
    public function providerClassesToTest()
    {
        return [
            ['Radowoj\Lexicon\Trie'],
            ['Radowoj\Lexicon\TrieArray']
        ];
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testAddedWordIsFound($class)
    {
        $trie = new $class();
        $trie->addWord('someWord');
        $this->assertTrue($trie->isWord('someWord'));
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testNotAddedWordIsNotFound($class)
    {
        $trie = new $class();
        $this->assertFalse($trie->isWord('someWord'));
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testUtf8($class)
    {
        $trie = new $class();
        $trie->addWord('czyłgana');
        $trie->addWord('ałmakuk');
        $trie->addWord('partędź');

        $this->assertTrue($trie->isWord('czyłgana'));
        $this->assertTrue($trie->isWord('ałmakuk'));
        $this->assertTrue($trie->isWord('partędź'));

        $this->assertFalse($trie->isWord('zięłło'));
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testIncompleteWordIsNotTreatedAsWord($class)
    {
        $trie = new $class();
        $trie->addWord('cats');
        $this->assertFalse($trie->isWord('cat'));
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testWordsWithCommonPrefixAreFound($class)
    {
        $trie = new $class();
        $trie->addWord('cat');
        $trie->addWord('cats');
        $this->assertTrue($trie->isWord('cat'));
        $this->assertTrue($trie->isWord('cats'));
    }


    /**
     * @dataProvider providerClassesToTest
     */
    public function testGetWordsByPrefix($class)
    {
        $trie = new $class();
        $trie->addWord('catnip');
        $trie->addword('dogma');
        $trie->addWord('cat');
        $trie->addWord('dog');

        $this->assertSame(['cat', 'catnip', 'dog', 'dogma'], $trie->getWordsByPrefix());
        $this->assertSame(['cat', 'catnip'], $trie->getWordsByPrefix('cat'));
    }

}
