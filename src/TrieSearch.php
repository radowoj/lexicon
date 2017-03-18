<?php

namespace Radowoj\Lexicon;

use stdClass;

trait TrieSearch
{

    /**
     * Find all words that consist of given rack of letters
     * @param  string $rack letters available
     * @param  string $mask @TODO constraint (e.g. row of game board)
     * @return array list of possible words matching given criteria
     */
    public function getWordsByRack(string $rack, string $mask = null) : array
    {
        $rack = preg_split('//u', $rack, -1, PREG_SPLIT_NO_EMPTY);
        return $this->searchWords($rack);
    }


    protected function searchWords(array $rack, string $prefix = null) : array
    {
        $node = $this->getNode((string)$prefix);

        $words = [];

        if (isset($node->isFinal)) {
            $words[] = $prefix;
        }

        foreach((array)$node as $letter => $nextNode) {
            $key = array_search($letter, $rack, true);
            if ($key !== false) {
                unset($rack[$key]);
            } else {
                continue;
            }

            $newPrefix = $prefix . $letter;
            $words = array_merge($words, $this->searchWords($rack, $newPrefix));
            $rack[] = $letter;
        }

        return $words;
    }
}
