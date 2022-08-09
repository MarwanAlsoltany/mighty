<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation;

use ReflectionClass;
use MAKS\Mighty\Validator;
use MAKS\Mighty\Rule;
use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Strategy as ConstraintStrategy;
use MAKS\Mighty\Validation\Constraint\Rule as RuleConstraint;
use MAKS\Mighty\Support\Utility;

/**
 * Generates rule constraints classes and markdown table by extracting rules from `Validation::class` metadata.
 *
 * This class is not meant to be used directly and is not part of the public API.
 *
 *
 * @package Mighty\Validator
 * @internal
 *
 * @codeCoverageIgnore
 */
class Maker
{
    /**
     * Make rule constraints classes.
     *
     * @param string|null $namespacePrefix [optional] Constraints namespace prefix (defaults to `Rule` constraint class short name).
     * @param string|null $classNameSuffix [optional] Constraints class name suffix (defaults to `Constraint` class short name).
     * @param bool $alwaysAddSuffix [optional] Whether or not to always add class name suffix or only when needed (when it is a reserved word).
     *
     * @return array An array of paths to the generated classes.
     */
    public static function makeConstraints(
        ?string $namespacePrefix = null,
        ?string $classNameSuffix = null,
        bool $alwaysAddSuffix = false,
    ): array {
        $methods = self::getValidationClassDocBlockMethods();
        $rules   = [];

        foreach ($methods as $method) {
            $rules[] = self::extractMetadataFromDocBlockMethod($method);
        }

        $constraintReflection = new ReflectionClass(RuleConstraint::class);
        $strategyReflection   = new ReflectionClass(ConstraintStrategy::class);

        $namespacePrefix ??= $constraintReflection->getShortName();
        $classNameSuffix ??= $constraintReflection->getParentClass()->getShortName();

        $directory = dirname($constraintReflection->getFileName());
        $directory = sprintf('%s/%s', $directory, strtr($namespacePrefix, ['\\' => '/']));

        $namespace = $constraintReflection->getNamespaceName();
        $namespace = sprintf('%s\%s', $namespace, strtr($namespacePrefix, ['/' => '\\']));

        self::clearConstraintsDirectory($directory);

        $classes = [];

        foreach ($rules as $rule) {
            $suffix = Validator::validateData($rule->name, Validation::if($alwaysAddSuffix, true)->or()->phpReservedExtra())->result;
            $suffix = $suffix ? $classNameSuffix : '';

            $name = sprintf('%s%s', $rule->name, $suffix);
            $file = sprintf('%s/%s.php', $directory, $name);

            $class = self::buildConstraintClass([
                'namespace'           => $namespace,
                'constraintClassFQN'  => $constraintReflection->getName(),
                'constraintClassName' => $constraintReflection->getShortName(),
                'strategyClassFQN'    => $strategyReflection->getName(),
                'strategyClassName'   => $strategyReflection->getShortName(),
                'className'           => $name,
                'ruleName'            => $rule->rule,
                'ruleArgumentsList'   => $rule->arguments->list,
                'ruleArgumentsFetch'  => $rule->arguments->fetch,
                'ruleSummary'         => $rule->summary,
            ]);

            file_put_contents($file, $class);

            $classes[] = realpath($file);
        }

        return $classes;
    }

    /**
     * Makes rules names as constants.
     *
     * @param string|null $namespacePrefix [optional] Class namespace prefix (defaults to `Rule` class short name).
     * @param string|null $className [optional] Class name (defaults to `Validation` class short name).
     *
     * @return string The path to the generated class.
     */
    public static function makeConstants(
        ?string $namespacePrefix = null,
        ?string $className = null,
    ): string {
        $ruleReflection       = new ReflectionClass(Rule::class);
        $validationReflection = new ReflectionClass(Validation::class);

        $namespacePrefix ??= $ruleReflection->getShortName();
        $className       ??= $validationReflection->getShortName();
        $summary           = 'Validation rule names and aliases constants.';

        $directory = dirname($ruleReflection->getFileName());
        $directory = sprintf('%s/%s', $directory, strtr($namespacePrefix, ['\\' => '/']));

        $namespace = $ruleReflection->getNamespaceName();
        $namespace = sprintf('%s\%s', $namespace, strtr($namespacePrefix, ['/' => '\\']));

        $validator = new Validator();
        $items     = [...$validator->getRules(), ...$validator->getAliases()];
        $keys      = array_keys($items);
        $values    = array_map(fn ($item) => Utility::transform($item, 'constant'), $keys);
        $items     = array_combine($keys, $values);
        $lengths   = array_map('strlen', $items);
        $length    = max($lengths);

        $constants = [];

        foreach ($items as $name => $constant) {
            $constants[] = Utility::interpolate(
                '{tab}public const {name} = {value};',
                [
                    'name'  => sprintf("%' -{$length}.{$length}s", $constant),
                    'value' => sprintf("'%s'", $name),
                    'tab'   => sprintf("%' 4s", ''),
                ]
            );
        }

        $classBody = implode("\n\n", $constants);

        $file = sprintf('%s/%s.php', $directory, $className);

        $class = self::buildConstantsClass([
            'namespace'     => $namespace,
            'summary'       => $summary,
            'className'     => $className,
            'classBody'     => $classBody,
        ]);

        file_put_contents($file, $class);

        return realpath($file);
    }

    /**
     * Makes rules markdown table.
     *
     * @param string|null $classNameSuffix [optional] Constraints class name suffix (defaults to `Constraint` class short name).
     * @param bool $alwaysAddSuffix [optional] Whether or not to always add class name suffix or only when needed (when it is a reserved word).
     *
     * @return string The markdown code.
     */
    public static function makeRulesMarkdownTable(
        ?string $classNameSuffix = null,
        bool $alwaysAddSuffix = false,
    ): string {
        $methods = self::getValidationClassDocBlockMethods();
        $rules   = [];

        foreach ($methods as $method) {
            $rules[] = self::extractMetadataFromDocBlockMethod($method);
        }

        $constraintReflection = new ReflectionClass(Constraint::class);

        $classNameSuffix ??= $constraintReflection->getShortName();

        $validator = new Validator();
        $objects   = [...$validator->getRules(), ...$validator->getAliases()];

        $table   = [];
        $table[] = '| No. | Rule | Description | Attribute / Method |';
        $table[] = '| --- | ---- | ----------- | ------------------ |';

        foreach ($rules as $index => $rule) {
            $suffix = Validator::validateData($rule->name, Validation::if($alwaysAddSuffix, true)->or()->phpReservedExtra())->result;
            $suffix = $suffix ? $classNameSuffix : '';

            $number = sprintf('%03d', strval($index + 1));
            $object = is_object($objects[$rule->rule]) ? $objects[$rule->rule] : null;

            [$name, $usage]       = [$object?->getName() ?? $rule->rule, $object?->getExample() ?? 'alias'];
            [$description]        = [$object?->getDescription() ?? 'alias'];
            [$attribute, $method] = [$rule->name . $suffix, $rule->signature];

            $table[] = Utility::interpolate(
                '| {number} | Name: `{name}`<br>Usage: {usage} | {description} ' .
                '| Attribute: <br>`{attribute}::class`<br>Method: <br>`Validation::{method}` |',
                [
                    'number'      => $number,
                    'name'        => $name,
                    'usage'       => $usage === 'alias' ? "see `{$objects[$name]}`" : "`{$usage}`",
                    'description' => $description === 'alias' ? "Alias, refer to `{$objects[$name]}` for the full description." : addcslashes($description, '_*#'),
                    'attribute'   => $attribute,
                    'method'      => addcslashes($method, '|'),
                ]
            );
        }

        $table = implode("\n", $table);

        return $table;
    }

    private static function getFileDocBlock(): string
    {
        $content = file_get_contents(__FILE__);
        $comment = preg_match('/(?<comment>\/\*\*.+?\*\/)/si', $content, $matches);
        $comment = $matches['comment'];

        return $comment;
    }

    /**
     * @return string[]
     */
    private static function getValidationClassDocBlockMethods(): array
    {
        $docBlock = (new ReflectionClass(Validation::class))->getDocComment();

        // split by new line
        $methods = explode("\n", $docBlock);
        // remove comment '/*', '*/', and whitespace
        $methods = array_map(fn ($method) => trim($method, '/ *'), $methods);
        // remove empty lines
        $methods = array_filter($methods);
        // reindex array keys
        $methods = array_values($methods);
        // remove lines before "Rules:"
        $methods = array_slice($methods, array_search('Rules:', $methods) + 1);
        // remove lines without "@method" tag
        $methods = array_filter($methods, fn ($method) => strpos($method, '@method') === 0);
        // reindex array keys
        $methods = array_values($methods);

        return $methods;
    }

    private static function extractMetadataFromDocBlockMethod(string $method): object
    {
        // @method mixed name(mixed $arg) Summary `name` more ...
        // @method <return> <signature <name>(<arguments>)> <summary `<rule>`>
        $pattern = '/^@method(?:\s(?:(?<type>static)\s)?(?<return>[a-z0-9_|]+)\s)(?<signature>(?<name>.+?)\((?<arguments>.*?)\))(?:\s(?<summary>.+?`(?<rule>.+?)`.+))$/i';
        $capture = preg_match($pattern, $method, $matches);
        $capture = array_filter($matches, fn ($key) => is_string($key), ARRAY_FILTER_USE_KEY);
        $success = array_walk($capture, fn (&$value, $key) => $value = match ($key) {
            'rule'      => strval($value),
            'name'      => ucfirst($value),
            'arguments' => [
                // the value is the argument list as defined
                'value' => $value = strval($value),
                // the count is used to get only the arguments required for the rule
                'count' => $count = substr_count($value, '$'),
                // the fetch is used to get back the required argument for the rule as expected (unpacked when necessary)
                'fetch' => $fetch = substr_count($value, '...') ? 'array_slice(func_get_args()[0], 0, null)' : "array_slice(func_get_args(), 0, {$count})",
                // the list will pack variadic arguments into an array to allow for adding more arguments to the rule
                'list'  => $count ? preg_replace('/([a-z|&]+)[ ][.]{3}(\$[a-z_]+)/i', 'array $2 /** @var array<$1> $2 Packed variadic. */', $value) . ', ' : $value,
            ],
            default => $value,
        });

        // cast to object recursively
        $result = json_encode($capture);
        $result = json_decode($result);

        return $result;
    }

    private static function clearConstraintsDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);

            return;
        }

        array_map(fn ($file) => unlink($file), glob($directory . '/*.php'));
    }

    /**
     * @param array<string,string> $variables
     */
    private static function buildConstraintClass(array $variables): string
    {
        $docBlock = self::getFileDocBlock();

        $lines   = [];
        $lines[] = '<?php';
        $lines[] = '';
        $lines[] = $docBlock;
        $lines[] = '';
        $lines[] = 'declare(strict_types=1);';
        $lines[] = '';
        $lines[] = 'namespace {namespace};';
        $lines[] = '';
        $lines[] = 'use Attribute;';
        $lines[] = 'use {strategyClassFQN};';
        $lines[] = 'use {constraintClassFQN};';
        $lines[] = '';
        $lines[] = '/**';
        $lines[] = ' * {ruleSummary}';
        $lines[] = ' *';
        $lines[] = ' * This is an auto-generated class that was generated programmatically by:';
        $lines[] = ' * `' . static::class . '`';
        $lines[] = ' *';
        $lines[] = ' * @package Mighty\Validator';
        $lines[] = ' *';
        $lines[] = ' * @codeCoverageIgnore There is nothing to test here. The underlying code is fully tested.';
        $lines[] = ' */';
        $lines[] = '#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]';
        $lines[] = 'final class {className} extends {constraintClassName}';
        $lines[] = '{';
        $lines[] = '    public const NAME = \'{ruleName}\';';
        $lines[] = '';
        $lines[] = '    public function __construct({ruleArgumentsList}?string $message = null, {strategyClassName} $strategy = {strategyClassName}::FailLazy)';
        $lines[] = '    {';
        $lines[] = '        $arguments = {ruleArgumentsFetch};';
        $lines[] = '';
        $lines[] = '        parent::__construct(name: self::NAME, arguments: $arguments, message: $message, strategy: $strategy);';
        $lines[] = '    }';
        $lines[] = '}';
        $lines[] = '';

        $template = implode("\n", $lines);
        $class    = Utility::interpolate($template, $variables);

        return $class;
    }

    /**
     * @param array<string,string> $variables
     */
    private static function buildConstantsClass(array $variables): string
    {
        $docBlock = self::getFileDocBlock();

        $lines   = [];
        $lines[] = '<?php';
        $lines[] = '';
        $lines[] = $docBlock;
        $lines[] = '';
        $lines[] = 'declare(strict_types=1);';
        $lines[] = '';
        $lines[] = 'namespace {namespace};';
        $lines[] = '';
        $lines[] = '/**';
        $lines[] = ' * {summary}';
        $lines[] = ' *';
        $lines[] = ' * This is an auto-generated class that was generated programmatically by:';
        $lines[] = ' * `' . static::class . '`';
        $lines[] = ' *';
        $lines[] = ' * @package Mighty\Validator';
        $lines[] = ' */';
        $lines[] = 'final class {className}';
        $lines[] = '{';
        $lines[] = '{classBody}';
        $lines[] = '';
        $lines[] = '';
        $lines[] = '    private function __construct()';
        $lines[] = '    {';
        $lines[] = '        // prevent class from being instantiated';
        $lines[] = '    }';
        $lines[] = '}';
        $lines[] = '';

        $template = implode("\n", $lines);
        $class    = Utility::interpolate($template, $variables);

        return $class;
    }
}
