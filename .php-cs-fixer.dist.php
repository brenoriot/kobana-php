<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->exclude([
        'vendor',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP54Migration' => true,
        '@PSR12' => true,
        '@PhpCsFixer' => true,
    ])
    ->setFinder($finder)
    ->setLineEnding("\n")
;
