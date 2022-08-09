<?php

use Doctum\Doctum;
use Doctum\Parser\Filter\TrueFilter;
use Doctum\Version\GitVersionCollection;
use Doctum\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$finder = (new Finder())
    ->in([
        __DIR__ . '/src',
    ])
    ->exclude([
        __DIR__ . '/tests',
        __DIR__ . '/vendor',
    ])
    ->files()
    ->name('/\.php$/')
    ->notName('/\.html\.php$/');

Doctum::$defaultVersionName = 'master';

return new Doctum($finder, getConfig());

function getConfig(): array {
    $owner = 'MarwanAlsoltany';
    $repo  = 'mighty';

    $filter   = new TrueFilter();
    $remote   = new GitHubRemoteRepository(implode('/', [$owner, $repo]), __DIR__);
    $versions = new GitVersionCollection(__DIR__ . '/src');
    $versions
        ->addFromTags('v1.*.*')
        ->add('master', 'Upstream (master)')
        ->setFilter(fn () => true);

    return [
        'base_url'              => "https://{$owner}.github.io/{$repo}",
        'title'                 => 'Mighty API Docs',
        'favicon'               => null,
        'language'              => 'en',
        'filter'                => $filter,
        // 'versions'              => $versions,
        'remote_repository'     => $remote,
        'build_dir'             => __DIR__ . '/build/doctum',
        'cache_dir'             => __DIR__ . '/build/doctum/.cache',
        'source_dir'            => __DIR__ . '/src',
        'default_opened_level'  => 2,
        'sort_class_properties' => true,
        'sort_class_methods'    => true,
        'sort_class_constants'  => true,
        'sort_class_traits'     => true,
        'include_parent_data'   => true,
        'insert_todos'          => false,
        'footer_link'           => [
            'href'        => "https://github.com/{$owner}/{$repo}",
            'rel'         => 'noreferrer noopener',
            'target'      => '_blank',
            'before_text' => 'Want to learn more about Mighty? Click ',
            'link_text'   => 'here',
            'after_text'  => 'to view the source code on GitHub!',
        ],
    ];
}
