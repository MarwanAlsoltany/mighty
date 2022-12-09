<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

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

$config = (new Config())
    ->setFinder($finder)
    ->setRules(getRules())
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFormat('txt')
    ->setCacheFile($cache = __DIR__ . '/build/php-cs-fixer/.php-cs-fixer.cache')
    ->setUsingCache(true)
    ->setHideProgress(false)
    ->setRiskyAllowed(true);

!realpath(dirname($cache)) && mkdir(dirname($cache), 0777, true);

return $config;

function getRules(): array {
    return [
        '@PSR1'  => true,
        '@PSR2'  => true,
        '@PSR12' => true,

        'assign_null_coalescing_to_coalesce_equal' => true,
        'binary_operator_spaces' => [
            'default' => null,
            'operators' => [
                // '=>' => 'align_single_space_minimal',
                // '=' => 'single_space',
                '|' => 'single_space',
            ]
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'phpdoc',
                'do',
                'exit',
                'for',
                'foreach',
                'goto',
                'if',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
                'yield_from',
            ],
        ],
        'single_blank_line_before_namespace' => true,
        'braces' => [
            'allow_single_line_closure' => true,
            'allow_single_line_anonymous_class_with_empty_body' => true,
            'position_after_control_structures' => 'same',
            'position_after_anonymous_constructs' => 'same',
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        'cast_spaces' => ['space' => 'none'],
        'class_attributes_separation' => [
            'elements' => [
                // 'const' => 'one',
                // 'property' => 'one',
                // 'trait_import' => 'one',
                // 'method' => 'one',
                // 'case' => 'one',
            ],
        ],
        'class_definition' => [
            'single_line' => false,
            'single_item_single_line' => true,
            'inline_constructor_arguments' => true,
            'multi_line_extends_each_single_line' => true,
            'space_before_parenthesis' => false,
        ],
        // 'class_keyword_remove' => false,
        'class_reference_name_casing' => true,
        'clean_namespace' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'combine_nested_dirname' => true,
        'comment_to_phpdoc' => false,
        'compact_nullable_typehint' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'constant_case' => [
            'case' => 'lower',
        ],
        'control_structure_continuation_position' => [
            'position' => 'same_line',
        ],
        'date_time_create_from_format_call' => true,
        'date_time_immutable' => false,
        'declare_parentheses' => false,
        'declare_equal_normalize' => [
            'space' => 'none'
        ],
        'declare_strict_types' => true,
        'dir_constant' => true,
        'echo_tag_syntax' => [
            'format' => 'short',
            'long_function' => 'echo',
            'shorten_simple_statements_only' => false,
        ],
        'elseif' => true,
        'empty_loop_body' => [
            'style' => 'semicolon',
        ],
        'empty_loop_condition' => [
            'style' => 'for',
        ],
        'encoding' => true,
        'ereg_to_preg' => true,
        'error_suppression' => false,
        'escape_implicit_backslashes' => [
            'single_quoted' => false,
            'double_quoted' => false,
            'heredoc_syntax' => false,
        ],
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'final_class' => false,
        'final_internal_class' => [
            'annotation_include' => ['@final'],
            'annotation_exclude' => ['@api'],
            'consider_absent_docblock_as_internal_class' => false,
        ],
        'final_public_method_for_abstract_class' => false,
        'fopen_flag_order' => true,
        'fopen_flags' => [
            'b_mode' => true,
        ],
        'full_opening_tag' => true,
        'fully_qualified_strict_types' => true,
        'function_declaration' => [
            'closure_function_spacing' => 'one',
            'trailing_comma_single_line' => false,
        ],
        'function_to_constant' => [
            'functions' => [
                'get_class',
                'get_class_this',
                'get_called_class',
                'php_sapi_name',
                'phpversion',
                'pi',
            ],
        ],
        'function_typehint_space' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                '@class'
            ]
        ],
        'general_phpdoc_tag_rename' => [
            'fix_annotation' => true,
            'case_sensitive' => true,
            'fix_inline' => true,
            'replacements' => [
                'inheritDocs' => 'inheritDoc',
            ],
        ],
        'get_class_to_class_keyword' => false,
        'global_namespace_import' => [
            'import_classes' => null,
            'import_constants' => null,
            'import_functions' => null,
        ],
        'group_import' => false,
        'header_comment' => [
            'comment_type' => 'PHPDoc',
            'header' => implode(PHP_EOL, [
                '@author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>',
                // the year falls back to the year the config file was created, replace it with code string to make it static
                '@copyright Marwan Al-Soltany ' . (($year = '2022') === '2022' ? gmdate('Y', filectime(__FILE__) ?: time()) : $year),
                'For the full copyright and license information, please view',
                'the LICENSE file that was distributed with this source code.',
            ]),
            'location' => 'after_open',
            'separate' => 'both',
        ],
        'heredoc_indentation' => [
            'indentation' => 'start_plus_one',
        ],
        'heredoc_to_nowdoc' => false,
        'implode_call' => true,
        'include' => false,
        'increment_style' => false,
        'indentation_type' => true,
        'line_ending' => true,
        'integer_literal_case' => true,
        'is_null' => false,
        'lambda_not_used_import' => true,
        'linebreak_after_opening_tag' => false,
        'list_syntax' => false,
        'logical_operators' => true,
        'lowercase_cast' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'mb_str_functions' => false,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
            'after_heredoc' => true,
        ],
        'method_chaining_indentation' => false,
        'modernize_strpos' => false,
        'modernize_types_casting' => false,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'native_constant_invocation' => [
            'scope' => 'all',
            'strict' => true,
            'exclude' => ['null', 'false', 'true'],
            'include' => [],
            'fix_built_in' => false,
        ],
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'new_with_braces' => [
            'anonymous_class' => true,
            'named_class' => true,
        ],
        'no_alias_functions' => [
            'sets' => ['@internal'],
        ],
        'no_alias_language_construct_call' => false,
        'no_alternative_syntax' => true,
        'no_binary_string' => false,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_blank_lines_before_namespace' => false,
        'no_break_comment' => [
            'comment_text' => '// ...',
        ],
        'no_closing_tag' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                // 'extra',
                // 'break',
                // 'case',
                // 'continue',
                // 'default',
                // 'return',
                // 'switch',
                // 'throw',
                // 'use',
                // 'use_trait',
                // 'curly_brace_block',
                // 'parenthesis_brace_block',
                // 'square_brace_block',
            ],
        ],
        'no_homoglyph_names' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => false,
        'no_null_property_initialization' => false,
        'no_php4_constructor' => true,
        'no_short_bool_cast' => false,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_space_around_double_colon' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_around_offset' => [
            'positions' => ['inside', 'outside'],
        ],
        'no_spaces_inside_parenthesis' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => [
            // 'allow_mixed' => true,
            // 'allow_unused_params' => true,
            // 'remove_inheritdoc' => false,
        ],
        'no_trailing_comma_in_singleline' => [
            'elements' => [
                'arguments',
                'array',
                'array_destructuring',
                'group_import',
            ],
        ],
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_trailing_whitespace_in_string' => false,
        'no_unneeded_control_parentheses' => [
            'statements' => [
                'break',
                'clone',
                'continue',
                'echo_print',
                'switch_case',
                'yield',
                'yield_from',
                // 'return',
            ],
        ],
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => [
            'private_methods' => true,
        ],
        'no_unneeded_import_alias' => true,
        'no_unreachable_default_argument_value' => false,
        'no_unset_cast' => true,
        'no_unset_on_property' => false,
        'no_unused_imports' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_useless_sprintf' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'non_printable_character' => false,
        'normalize_index_brace' => true,
        'not_operator_with_space' => false,
        'not_operator_with_successor_space' => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'object_operator_without_whitespace' => true,
        'octal_notation' => false,
        'operator_linebreak' => [
            'only_booleans' => true,
            'position' => 'end',
        ],
        'ordered_interfaces' => false,
        'ordered_traits' => false,
        'ordered_class_elements' => [
            'sort_algorithm' => 'none', // alpha, none
            'order' => [
                'use_trait',
                'constant',
                // 'constant_private',
                // 'constant_protected',
                // 'constant_public',
                'property_static',
                // 'property_public_static',
                // 'property_private_static',
                // 'property_protected_static',
                'property',
                // 'property_public',
                // 'property_public_readonly',
                // 'property_protected',
                // 'property_protected_readonly',
                // 'property_private',
                // 'property_private_readonly',
                'public',
                'protected',
                'private',
                'case',
                'construct',
                'destruct',
                'magic',
                'method',
                // 'method_abstract',
                // 'method_public_abstract',
                // 'method_protected_abstract',
                // 'method_private_abstract',
                // 'method_public',
                // 'method_protected',
                // 'method_private',
                // 'method_public_abstract_static',
                // 'method_protected_abstract_static',
                // 'method_private_abstract_static',
                // 'method_static',
                // 'method_public_static',
                // 'method_protected_static',
                // 'method_private_static',
                'phpunit',
            ],
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'none', // alpha, length, none
            'imports_order' => [
                'const',
                'class',
                'function',
            ]
        ],
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false,
        ],
        'phpdoc_indent' => true,
        'phpdoc_align' => [
            'align' => 'left', // left, vertical
            'tags' => [
                // 'type',
                // 'property',
                // 'property-read',
                // 'property-write',
                // 'var',
                // 'param',
                // 'method',
                // 'return',
                // 'throws',
            ],
        ],
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_inline_tag_normalizer' => [
            'tags' => [
                'example',
                'id',
                'internal',
                'inheritdoc',
                'link',
                'source',
                'toc',
                'tutorial',
            ],
        ],
        'phpdoc_line_span' => [
            'const' => 'multi', // single, multi, null
            'property' => 'multi', // single, multi, null
            'method' => 'multi', // single, multi, null
        ],
        'phpdoc_no_access' => false,
        'phpdoc_no_alias_tag' => [
            'replacements' => [
                'type' => 'var',
            ],
        ],
        'phpdoc_no_empty_return' => false,
        'phpdoc_no_package' => false,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => false,
        'phpdoc_order_by_value' => [
            'annotations' => [
                'dataProvider',
                'depends',
                'covers',
                'coversNothing',
                'group',
                'internal',
                'requires',
                'uses',
                'author',
                // 'method',
                // 'property',
                // 'property-read',
                // 'property-write',
                // 'throws',
            ],
        ],
        'phpdoc_return_self_reference' => [
            'replacements' => [
                'this' => '$this',
                '@this' => '$this',
                '$self' => 'self',
                '@self' => 'self',
                '$static' => 'static',
                '@static' => 'static',
            ],
        ],
        'phpdoc_scalar' => [
            'types' => [
                'boolean',
                'integer',
                'real',
                'double',
                'callback',
                'str',
            ],
        ],
        'phpdoc_separation' => false,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => [
            'tags' => [
                'inheritDoc',
                'param',
                'return',
                'throws',
            ],
        ],
        'phpdoc_tag_type' => [
            'tags' => [
                'api' => 'annotation',
                'author' => 'annotation',
                'copyright' => 'annotation',
                'deprecated' => 'annotation',
                'example' => 'annotation',
                'global' => 'annotation',
                'inheritDoc' => 'inline',
                'internal' => 'annotation',
                'license' => 'annotation',
                'method' => 'annotation',
                'package' => 'annotation',
                'param' => 'annotation',
                'property' => 'annotation',
                'return' => 'annotation',
                'see' => 'inline',
                'since' => 'annotation',
                'throws' => 'annotation',
                'todo' => 'annotation',
                'uses' => 'annotation',
                'var' => 'annotation',
                'version' => 'annotation'
            ],
        ],
        'phpdoc_to_comment' => [
            'ignored_tags' => [
                'var',
            ],
        ],
        'phpdoc_to_param_type' => [
            'scalar_types' => true,
        ],
        'phpdoc_to_property_type' => [
            'scalar_types' => true,
        ],
        'phpdoc_to_return_type' => [
            'scalar_types' => true,
        ],
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => false,
        'phpdoc_types' => [
            'groups' => [
                'simple',
                'alias',
                'meta',
            ],
        ],
        'phpdoc_types_order' => [
            'sort_algorithm' => 'none', // alpha, none
            'null_adjustment' => 'none', // always_first, always_last, none
        ],
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,
        'pow_to_exponentiation' => false,
        'protected_to_private' => false,
        'psr_autoloading' => [
            'dir' => __DIR__ . '/src',
        ],
        'random_api_migration' => [
            'replacements' => [
                // 'rand' => 'mt_rand',
                // 'srand' => 'mt_srand',
                // 'getrandmax' => 'mt_getrandmax',
            ],
        ],
        'regular_callable_call' => true,
        'return_assignment' => false,
        'return_type_declaration' => [
            'space_before' => 'none', // none, one
        ],
        'self_accessor' => false,
        'self_static_accessor' => true,
        'semicolon_after_instruction' => false,
        'set_type_to_cast' => false,
        'short_scalar_cast' => true,
        'simple_to_complex_string_variable' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => false,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => [
            'elements' => [
                'const',
                'property',
            ],
        ],
        'single_import_per_statement' => false,
        'single_line_after_imports' => true,
        'single_line_comment_spacing' => true,
        'single_line_comment_style' => [
            'comment_types' => [
                'asterisk',
                'hash',
            ],
        ],
        'single_line_throw' => false,
        'single_quote' => true,
        'single_space_after_construct' => [
            'constructs' => [
                'abstract',
                'as',
                'attribute',
                'break',
                'case',
                'catch',
                'class',
                'clone',
                'comment',
                'const',
                'const_import',
                'continue',
                'do',
                'echo',
                'else',
                'elseif',
                'enum',
                'extends',
                'final',
                'finally',
                'for',
                'foreach',
                'function',
                'function_import',
                'global',
                'goto',
                'if',
                'implements',
                'include',
                'include_once',
                'instanceof',
                'insteadof',
                'interface',
                'match',
                'named_argument',
                'namespace',
                'new',
                'open_tag_with_echo',
                'php_doc',
                'php_open',
                'print',
                'private',
                'protected',
                'public',
                'readonly',
                'require',
                'require_once',
                'return',
                'static',
                'switch',
                'throw',
                'trait',
                'try',
                'use',
                'use_lambda',
                'use_trait',
                'var',
                'while',
                'yield',
                'yield_from',
            ],
        ],
        'single_trait_insert_per_statement' => true,
        'space_after_semicolon' => true,
        'standardize_increment' => false,
        'standardize_not_equals' => true,
        'static_lambda' => false,
        'strict_comparison' => false,
        'strict_param' => false,
        'string_length_to_empty' => false,
        'string_line_ending' => false,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'switch_continue_to_break' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_elvis_operator' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                'arrays',
                'parameters',
                // 'arguments',
            ],
        ],
        'trim_array_spaces' => true,
        'types_spaces' => [
            'space' => 'none', // none, single
            'space_multiple_catch' => 'single', // none, single, null
        ],
        'unary_operator_spaces' => true,
        'use_arrow_functions' => true,
        'visibility_required' => [
            'elements' => [
                'property',
                'method',
                'const',
            ],
        ],
        'void_return' => false,
        'whitespace_after_comma_in_array' => true,
        'yoda_style' => [
            'always_move_variable' => false,
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
    ];
}
