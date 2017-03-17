<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Radowoj\Lexicon\Trie;

$trie = new Trie();

$trie->addWord('kotek');
$trie->addWord('kołek');
$trie->addWord('kot');
$trie->addWord('kotowaty');

$wordsToSearch = ['kot', 'kołczan'];

foreach($wordsToSearch as $word) {
    echo "{$word} is " . ($trie->isWord($word) ? "a valid word" : "an invalid word") . "\n";
}
