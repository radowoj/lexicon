<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Radowoj\Lexicon\Trie;
use Radowoj\Lexicon\TrieArray;
use Radowoj\Lexicon\Dawg;
use Radowoj\Lexicon\Lexicon;

function profile(Closure $closure) {
    $startMem = memory_get_usage();
    $startTime = microtime(true);

    $closure();

    return [
        'memory' => memory_get_usage() - $startMem,
        'time' => round(microtime(true) - $startTime, 5),
    ];
}


function profileLexicon(Lexicon $lexicon, array $words) : string
{
    $buildStats = profile(function() use ($lexicon, $words) {
        foreach($words as $word) {
            $lexicon->addWord(trim($word));
        }
    });

    $checkStats = profile(function() use ($lexicon) {
        for($i=0; $i<10000; $i++) {
            $lexicon->isWord('abakan');
        }
    });

    $searchStats = profile(function() use($lexicon) {
        for($i=0; $i<10000; $i++) {
            $lexicon->getWordsByRack('abakan');
        }
    });

    $prefixSearchStats = profile(function() use($lexicon) {
        for($i=0; $i<10000; $i++) {
            $lexicon->getWordsByPrefix('abaż');
        }
    });

    $class = get_class($lexicon);
    return "Class: {$class};\n"
        . "\tMemory: {$buildStats['memory']};\n"
        . "\tBuild time: {$buildStats['time']};\n"
        . "\t10k checks time: {$checkStats['time']}\n"
        . "\t10k searches time: {$searchStats['time']}\n"
        . "\t10k prefix searches time: {$prefixSearchStats['time']}\n";
}

$words = file('wordlist.txt');
$lexicons = [
    new Trie(),
    new TrieArray()
];


foreach($lexicons as $lexicon) {
    echo profileLexicon($lexicon, $words) . "\n";
}
