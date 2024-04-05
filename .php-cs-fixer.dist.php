<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(['bootstrap', 'storage', 'database/migrations'])
    ->notPath(['_ide_helper.php', 'server.php', 'public/index.php'])
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);


return (new \Jubeki\LaravelCodeStyle\Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        'LaravelCodeStyle/laravel_phpdoc_alignment'    => false,
        'binary_operator_spaces'              => [
            'operators' => [
                '=>' => 'align',
                '='  => 'align',
                '|'  => 'single_space',
            ],
        ],
        'cast_spaces'                         => ['space' => 'none'],
        'class_attributes_separation'         => false,
        'concat_space'                        => ['spacing' => 'one'],
        'declare_strict_types'                => true,
        'is_null'                             => true,
        'no_spaces_around_offset'             => true,
        'not_operator_with_space'             => false,
        'not_operator_with_successor_space'   => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order'                        => true,
        'simplified_null_return'              => false,
        'phpdoc_to_comment'                   => false,
        'phpdoc_summary'                      => false,
        'yoda_style'                          => false,
        'blank_line_before_statement'         => [
            'statements' => [
                'case',
                'default',
                'return',
            ],
        ],
    ]);
