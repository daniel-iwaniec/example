<?php

return PhpCsFixer\Config::create()
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__ . '/src'))
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_equal_normalize' => ['space' => 'single'],
        'declare_strict_types' => true,
        'concat_space' => ['spacing' => 'one'],
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'phpdoc_align' => ['align' => 'left']
    ]);
