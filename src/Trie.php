<?php

namespace Radowoj\Lexicon;

use stdClass;

class Trie implements Lexicon
{
    use TrieSearch;

    const FINAL_KEY = 'isFinal';

    protected $root;

    protected $currentNode;

    public function __construct()
    {
        $this->root = new stdClass;
        $this->reset();
    }


    protected function reset()
    {
        $this->currentNode = &$this->root;
    }


    public function addWord(string $word)
    {
        $this->reset();

        $letters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);

        foreach($letters as $letter) {
            if (!isset($this->currentNode->$letter)) {
                $this->currentNode->{$letter} = new stdClass;
            }

            $this->currentNode = &$this->currentNode->{$letter};
        }

        $this->currentNode->{self::FINAL_KEY} = true;
    }


    protected function getNode(string $prefix) : stdClass
    {
        $this->reset();
        $letters = preg_split('//u', $prefix, -1, PREG_SPLIT_NO_EMPTY);

        foreach($letters as $letter) {
            if (!isset($this->currentNode->{$letter})) {
                return new stdClass;
            }

            $this->currentNode = &$this->currentNode->{$letter};
        }

        return $this->currentNode;
    }


    public function isWord(string $word) : bool
    {
        $node = $this->getNode($word);
        return isset($node->{self::FINAL_KEY});
    }


    public function getWordsByPrefix(string $prefix = null) : array
    {
        $node = $this->getNode((string)$prefix);

        $words = [];

        if (isset($node->{self::FINAL_KEY})) {
            $words[] = $prefix;
        }

        foreach((array)$node as $letter => $nextNode) {
            $newPrefix = $prefix . $letter;
            $words = array_merge($words, $this->getWordsByPrefix($newPrefix));
        }

        return $words;
    }



}
