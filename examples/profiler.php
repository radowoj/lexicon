<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Radowoj\Lexicon\Trie;
use Radowoj\Lexicon\TrieArray;
use Radowoj\Lexicon\Dawg;
use Radowoj\Lexicon\Lexicon;

function profileLexicon(Lexicon $lexicon, array $words) : string
{
    //lexicon build start
    $startMem = memory_get_usage();
    $startBuildTime = microtime(true);

    foreach($words as $word) {
        $lexicon->addWord(trim($word));
    }

    //lexicon build finish
    $mem = memory_get_usage() - $startMem;
    $time = round(microtime(true) - $startBuildTime, 2);

    //searches test start
    $startSearchTime = microtime(true);
    for($i=0; $i<100000; $i++) {
        $lexicon->isWord('abakan');
    }
    //searches test finish
    $searchTime = round(microtime(true) - $startSearchTime, 2);

    $class = get_class($lexicon);
    return "Class: {$class}; Memory: {$mem}; Build time: {$time}; 100k searches time: {$searchTime}";

}

$words = file('wordlist.txt');

$objectsToProfile = [
    new Trie(),
    new TrieArray()
];

foreach($objectsToProfile as $object) {
    echo profileLexicon($object, $words) . "\n";
}
