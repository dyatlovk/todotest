<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('vendor')
    ->append([__FILE__])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => [
            'spacing' => 'one',
        ],
    ])
    ->setFinder($finder)
;
