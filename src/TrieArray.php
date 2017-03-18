<?php

namespace Radowoj\Lexicon;

/**
 * Trie implementation using internal array instead of stdClass for storing nodes.
 * Slower but a bit more memory efficient
 */
class TrieArray implements Lexicon
{
    use TrieSearch;

    const FINAL_KEY = 'isFinal';

    protected $nodes = [];

    protected $currentNode = null;

    protected function reset()
    {
        $this->currentNode = &$this->nodes;
    }

    public function addWord(string $word)
    {
        $this->reset();
        $letters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);

        foreach($letters as $letter) {
            if (!array_key_exists($letter, $this->currentNode)) {
                $this->currentNode[$letter] = [];
            }

            $this->currentNode = &$this->currentNode[$letter];

        }

        $this->currentNode[self::FINAL_KEY] = true;
    }


    protected function getNode(string $prefix) : array
    {
        $this->reset();
        $letters = preg_split('//u', $prefix, -1, PREG_SPLIT_NO_EMPTY);

        foreach($letters as $letter) {
            if (!array_key_exists($letter, $this->currentNode)) {
                return [];
            }
            $this->currentNode = &$this->currentNode[$letter];
        }

        return $this->currentNode;
    }


    public function isWord(string $word) : bool
    {
        $node = $this->getNode($word);
        return isset($node[self::FINAL_KEY]);
    }


    public function getWordsByPrefix(string $prefix = null) : array
    {
        $node = $this->getNode((string)$prefix);

        $words = [];

        if (isset($node[self::FINAL_KEY])) {
            $words[] = $prefix;
        }

        foreach($node as $letter => $nextNode) {
            $newPrefix = $prefix . $letter;
            $words = array_merge($words, $this->getWordsByPrefix($newPrefix));
        }

        return $words;
    }
}
