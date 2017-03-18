<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Radowoj\Lexicon\Trie;

$trie = new Trie();

$trie->addWord('kotek');
$trie->addWord('kołek');
$trie->addWord('kotowaty');
$trie->addWord('to');
$trie->addWord('tok');
$trie->addWord('ok');
$trie->addWord('oko');

$wordsToSearch = ['kot', 'kołczan', 'kołek'];

//check if words exist in dictionary
foreach($wordsToSearch as $word) {
    echo "{$word} is " . ($trie->isWord($word) ? "a valid word" : "an invalid word") . "\n";
}

var_dump(
    //all words added to dictionary
    $trie->getWordsByPrefix(),

    //words starting with prefix
    $trie->getWordsByPrefix('kot'),

    //words consisting of given letters
    $trie->getWordsByRack('koot')
);
