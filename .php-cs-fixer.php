<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new Finder())
    ->in([
        sprintf('%s/config', __DIR__),
        sprintf('%s/src', __DIR__),
    ]);

return (new Config())
    ->setRules([
        '@Symfony' => true,
        'global_namespace_import' => [
            'import_constants' => true,
            'import_functions' => true,
        ],
    ])
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect());
