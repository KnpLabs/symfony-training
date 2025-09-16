<?php

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__)
    ->exclude('var')
;

return new PhpCsFixer\Config()
    ->setRules([
        '@PhpCsFixer:risky' => true,
        '@PHP8x4Migration' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setUsingCache(false)
;
