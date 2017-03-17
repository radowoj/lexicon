<?php

namespace Radowoj\Lexicon;

use stdClass;

class Trie implements Lexicon
{
    protected $root;

    protected $currentNode;

    public function __construct()
    {
        $this->root = new stdClass;
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

        $this->currentNode->isFinal = true;
    }


    protected function getNode($prefix) : stdClass
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
        return isset($node->isFinal);
    }







}
