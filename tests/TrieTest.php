<?php

namespace Radowoj\Lexicon;

use PHPUnit\Framework\TestCase;
use Radowoj\Lexicon\Trie;

class TrieTest extends TestCase
{
    public function testAddedWordIsFound()
    {
        $trie = new Trie();
        $trie->addWord('someWord');
        $this->assertTrue($trie->isWord('someWord'));
    }


    public function testNotAddedWordIsNotFound()
    {
        $trie = new Trie();
        $this->assertFalse($trie->isWord('someWord'));
    }


    public function testUtf8()
    {
        $trie = new Trie();
        $trie->addWord('czyłgana');
        $trie->addWord('ałmakuk');
        $trie->addWord('partędź');

        $this->assertTrue($trie->isWord('czyłgana'));
        $this->assertTrue($trie->isWord('ałmakuk'));
        $this->assertTrue($trie->isWord('partędź'));

        $this->assertFalse($trie->isWord('zięłło'));
    }


    public function testIncompleteWordIsNotTreatedAsWord()
    {
        $trie = new Trie();
        $trie->addWord('cats');
        $this->assertFalse($trie->isWord('cat'));
    }


    public function testWordsWithCommonPrefixAreFound()
    {
        $trie = new Trie();
        $trie->addWord('cat');
        $trie->addWord('cats');
        $this->assertTrue($trie->isWord('cat'));
        $this->assertTrue($trie->isWord('cats'));
    }



}
