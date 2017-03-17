<?php

namespace Radowoj\Lexicon;

interface Lexicon
{
    public function addWord(string $word);

    public function isWord(string $word) : bool;

    public function getWordsByPrefix(string $prefix) : array;
}
