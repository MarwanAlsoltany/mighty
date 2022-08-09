<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty;

use Throwable;
use Traversable;
use MAKS\Mighty\Engine;
use MAKS\Mighty\Rule;
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Behavior;
use MAKS\Mighty\Support\Utility;
use MAKS\Mighty\Exception;
use MAKS\Mighty\Exception\ValidatorThrowable;
use MAKS\Mighty\Exception\ValidationFailedException;
use MAKS\Mighty\Exception\UnknownValidationRuleException;
use MAKS\Mighty\Exception\InexecutableRuleException;
use MAKS\Mighty\Exception\InvalidRuleDefinitionException;
use MAKS\Mighty\Exception\InvalidRuleAliasException;
use MAKS\Mighty\Exception\InvalidRuleMacroException;

/**
 * Validator class.
 *
 * Example:
 * ```
 * $validator = new Validator();
 *
 * $data = [
 *     'name'  => 'John Doe',
 *     'age'   => 25,
 *     'email' => 'john.doe@domain.tld',
 * ];
 *
 * $validations = [
 *     'name'  => $validator->validation()->required()->string()->stringCharset('UTF-8')->pessimistic(),
 *     'age'   => $validator->validation()->required()->integer()->min(18),
 *     'email' => $validator->validation()->required()->email(),
 * ];
 *
 * $labels = [
 *     'name'  => 'Name',
 *     'age'   => 'Age',
 *     'email' => 'E-Mail',
 * ];
 *
 * $messages = [
 *     '*' => [ // this will be expanded to all fields
 *         'required' => '${@label} is a required field.',
 *     ],
 *     'age' => [
 *         'min' => '${@label} must be at least ${@arguments.0}.',
 *     ],
 * ];
 *
 * $validator
 *     ->setData($data)
 *     ->setValidations($validations)
 *     ->setMessages($messages)
 *     ->setLabels($labels)
 *     ->validate();
 *
 * $errors = $validator->getErrors();
 * // []
 * $passed = $validator->isOK();
 * // true
 * $results = $validator->getResults();
 *
 * // $results should look like this:
 * [
 *     // items will actually be a Result object
 *     // array syntax is used here for demonstration purposes
 *    'name' => [ // Result object
 *        'key' => 'name',
 *        'value' => 'John Doe',
 *        'result' => true,
 *        'validations' => [
 *            'required' => true,
 *            'string' => true,
 *            'string.charset' => true,
 *        ],
 *      'errors' => [],
 *      'metadata' => [
 *          'basis' => '!required&string&string.charset:"UTF-8"',
 *          'rules' => 'required&string&string.charset:"UTF-8"',
 *          'expression' => '1&1&1',
 *      ],
 *    ],
 *    // ...
 * ];
 * ```
 *
 * @package Mighty\Validator
 * @api
 */
class Validator
{
    /**
     * Validation logic path.
     *
     * @var string
     */
    private const LOGIC_PATH = __DIR__ . '/Validation/Logic';

    /**
     * Default validation rules array path.
     *
     * @var string
     */
    protected const DEFAULT_RULES_PATH = self::LOGIC_PATH . '/rules.php';

    /**
     * Default validation rules aliases array path.
     *
     * @var string
     */
    protected const DEFAULT_ALIASES_PATH = self::LOGIC_PATH . '/aliases.php';

    /**
     * Default validation rules macros array path.
     *
     * @var string
     */
    protected const DEFAULT_MACROS_PATH = self::LOGIC_PATH . '/macros.php';


    /**
     * Available validation rules.
     *
     * @var array<string,Rule>
     */
    protected array $rules;

    /**
     * Available validation rules aliases.
     *
     * @var array<string,string>
     */
    protected array $aliases;

    /**
     * Available validation rules macros.
     *
     * @var array<string,string>
     */
    protected array $macros;

    /**
     * The currently validated data key.
     *
     * @var string
     */
    protected string $current;

    /**
     * Currently loaded data.
     *
     * @var array<mixed>
     */
    protected array $data;

    /**
     * Currently loaded validations.
     *
     * @var array<string|int,string|Validation>
     */
    protected array $validations;

    /**
     * Currently loaded validation messages.
     *
     * @var array<string,array<string,string|null>>
     */
    protected array $messages;

    /**
     * Currently loaded validation labels.
     *
     * @var array<string,string>
     */
    protected array $labels;

    /**
     * Current validation context (available results).
     *
     * @var array<string,array<string,mixed>>
     */
    protected array $context;

    /**
     * Validations results against the currently loaded data.
     *
     * @var array<string,Result>
     */
    protected array $results;

    /**
     * Validation errors of the currently loaded data.
     *
     * @var array<string,Result>
     */
    protected array $errors;


    /**
     * Validator constructor.
     *
     * @param array<mixed>|Traversable<mixed> $data [optional] The data to validate.
     * @param array<string|int,string|Validation> $validations [optional] The validation rules for each data key.
     */
    public function __construct(?iterable $data = null, ?array $validations = null)
    {
        $this->reset();

        $this->setData($data ?? $this->data);
        $this->setValidations($validations ?? $this->validations);
    }

    /**
     * Resets validator's internal state when cloned.
     *
     * @return void
     */
    public function __clone(): void
    {
        $this->reset();
    }


    /**
     * Resets validator's internal state.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->current     = '';
        $this->data        = [];
        $this->validations = [];
        $this->messages    = [];
        $this->labels      = [];

        $this->context = [];
        $this->results = [];
        $this->errors  = [];

        $this->rules   = $this->getRules();
        $this->aliases = $this->getAliases();
        $this->macros  = $this->getMacros();
    }

    /**
     * Sets the data to validate.
     *
     * @param array<mixed>|Traversable<mixed> $data The data to validate.
     *
     * @return static
     */
    public function setData(iterable $data): static
    {
        $this->data = is_object($data) && is_a($data, Traversable::class) ? iterator_to_array($data) : $data;

        return $this;
    }

    /**
     * Sets the validation expression for each data key.
     *
     * @param array<string|int,string|Validation> $validations The validation expression for each data key.
     *      Nested elements can be accessed using dot notation (`someKey.someNestedKey`).
     *      Keys can have the wildcard `*` after a dot to match all nested keys.
     *
     * @return static
     */
    public function setValidations(array $validations): static
    {
        $this->validations = $validations;

        return $this;
    }

    /**
     * Sets rule message override for each validation rule of each data key.
     *
     * @param array<string,array<string,string|null>> $messages An associative array where key is a data key
     *      and value is an associative array where key is the rule name and value is the message.
     *      See `MAKS\Mighty\Rule::SCHEMA['@message']` for more info about placeholders.
     *      Nested elements can be accessed using dot notation (`someKey.someNestedKey`).
     *      Keys can have the wildcard `*` after a dot to match all nested keys.
     *
     * @return static
     */
    public function setMessages(array $messages): static
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Sets labels for each data key. These labels will be injected in validation messages.
     *
     * @param array<string,string|null> $labels An associative array where key is a data key and value is the label.
     *      Nested elements can be accessed using dot notation (`someKey.someNestedKey`).
     *      Keys can have the wildcard `*` after a dot to match all nested keys.
     *
     * @return static
     */
    public function setLabels(array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Returns validation results (errors and successes).
     *
     * @return array<string,Result>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Returns validation errors.
     *
     * @return array<string,Result>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Checks whether the validation has passed or not.
     *
     * @return bool
     */
    public function isOK(): bool
    {
        return count($this->getErrors()) === 0;
    }

    /**
     * Returns an instance of the validation expression builder.
     *
     * @return Validation
     */
    public function validation(): Validation
    {
        return new Validation($this);
    }

    /**
     * Checks current validator's data against current validator's validations.
     *
     * @throws ValidationFailedException If the data did not pass the validation.
     *
     * @return void
     */
    public function check(): void
    {
        $this->validate();

        if ($this->isOK()) {
            return;
        }

        $errors = $this->getErrors();

        $errors = array_map(function ($error) {
            return Utility::interpolate(
                'The value of "{key}" (validation: [{rules}]; expression: [{expression}]) ' .
                'has the following error(s): {errors}',
                [
                    'key'        => $error['key'],
                    'rules'      => $error['metadata']['rules'],
                    'expression' => $error['metadata']['expression'],
                    'errors'     => strval($error),
                ]
            );
        }, $errors);

        $count  = 0;
        $errors = array_reduce($errors, function ($carry, $item) use (&$count) {
            return sprintf("%s\n(%02d) %s", $carry, ++$count, $item);
        });

        throw new ValidationFailedException(
            'Data failed to pass the validation. Problem(s): ' . $errors
        );
    }

    /**
     * Validates current validator's data against current validator's validations and return the results.
     *
     * @return array<string,Result> The validation results.
     *
     * @throws UnknownValidationRuleException If the rule is unknown.
     * @throws InexecutableRuleException If rule execution failed.
     * @throws InvalidBitwiseExpressionException If the bitwise expression resulting from the validation expression is invalid.
     */
    public function validate(): array
    {
        return $this->validateAll($this->data, $this->validations);
    }

    /**
     * Validates the passed data against the passed validations.
     *
     * @param array<mixed>|Traversable<mixed> $data The data to validate.
     * @param array<string|int,string|Validation> $validations The validation expression for each data key.
     *      Nested elements can be accessed using dot notation (`someKey.someNestedKey`).
     *      Keys can have the wildcard `*` after a dot to match all nested keys.
     *
     * @return array<string,Result> The validation results.
     *
     * @throws UnknownValidationRuleException If a validation rule is unknown.
     * @throws InexecutableRuleException If rule execution failed.
     * @throws InvalidBitwiseExpressionException If the bitwise expression resulting from the validation expression is invalid.
     */
    public function validateAll(iterable $data, array $validations): array
    {
        $this->context = [];
        $this->errors  = [];
        $this->results = [];

        $this->setData($data);
        $this->setValidations($validations);

        $validate = function (string $key, string $rules): void {
            $value = Utility::getArrayValue($this->data, $key, null);

            $this->current = $key;
            $this->context['this'] = $value;

            $rules = Utility::injectInString($rules, $this->context);

            $check = $this->validateOne($value, $rules);

            $this->results[$this->current] = $check->addAttribute('key', $key);

            if ($check->getResult() === false) {
                $this->errors[$this->current] = $this->results[$this->current];
            }

            $this->context[$this->current] = $check->toArray();
            $this->current = '';
        };

        // expand wildcards
        $this->validations = Utility::expandArrayWildcards($this->validations, $this->data);
        $this->messages    = Utility::expandArrayWildcards($this->messages, $this->data);
        $this->labels      = Utility::expandArrayWildcards($this->labels, $this->data);

        foreach ($this->validations as $key => $validation) {
            $key        = strval($key);
            $validation = strval($validation);

            if (empty(trim($validation))) {
                continue;
            }

            $validate($key, $validation);
        }

        return $this->getResults();
    }

    /**
     * Validates a single value against the passed validation.
     *
     * @param mixed $value The value to validate.
     * @param string|Validation $validation The validation expression string or object.
     *
     * @return Result The validation result.
     *
     * @throws UnknownValidationRuleException If a validation rule is unknown.
     * @throws InexecutableRuleException If rule execution failed.
     * @throws InvalidBitwiseExpressionException If the bitwise expression resulting from the validation expression is invalid.
     */
    public function validateOne(mixed $value, Validation|string $validation): Result
    {
        // validation expression string as passed
        $basis = strval($validation);

        // validation expression string with macros injected
        $validation = strtr($basis, $this->getMacros());
        // check whether the validation expression behavior is optimistic/pessimistic or not
        $validation = trim($validation);
        $behavior   = substr($validation, 0, 1);
        $behaviors  = [
            // '?' [OPTIMISTIC]: continue after first success (true)
            Behavior::Optimistic->value  => true,
            // '!' [PESSIMISTIC]: break after first failure (false)
            Behavior::Pessimistic->value => false,
            // '*' [NORMAL]: anything else, execute all rules (null)
        ];
        $behavior   = $behaviors[$behavior] ?? null;
        $validation = $behavior === null ? $validation : substr($validation, 1);

        $expression  = $rules = $validation;
        $bits        = [];
        $validations = [];

        $checks = Engine::parseExpression($expression);

        foreach ($checks as $name => $statement) {
            $result = $this->executeRule($name, $statement, $value);

            $validations[$name] = $result;
            $bits[$statement]   = (string)(int)(bool)$result; // (string)(int)(bool) to cast to a bit ('0' or '1')

            // replace the rule (statement) with its result (bit) to build up the bitwise expression
            // here only the first occurrence of the rule (statement) will be replaced because some rules
            // can be a substring of other rules, which will mess up the expression and render it useless
            $expression = substr_replace($expression, $bits[$statement], intval(strpos($expression, $statement)), strlen($statement));

            // if the validation is optimistic/pessimistic and the current result matches a behavior, stop the validation
            if ($result === $behavior) {
                // fill all not executed validations with null
                $results      = array_fill_keys(array_keys($checks), null);
                $validations  = array_merge($results, $validations);
                // replace all not replaced rules in the expression with either '0' or '1'
                $results      = array_fill(0, count($checks), (string)(int)(bool)$behavior);
                $replacements = array_combine(array_values($checks), $results);

                $expression   = strtr($expression, $replacements);

                break;
            }
        }

        // the loop above will replace only the first occurrence of the rule
        // sometimes the same rule is added more than once, this should never happen
        // but to mitigate that error, replace any left over rules in the expression
        // with their corresponding bits (using the cached $bits array)
        $expression = strtr($expression, $bits);
        // remove whitespace from the expression
        $expression = strtr($expression, [' ' => '']);

        $result = Engine::evaluateBitwiseExpression($expression);

        $errors = $result ? [] : $this->createErrorMessages($validations);

        return Result::from([
            'value'       => $value,
            'result'      => $result,
            'validations' => $validations,
            'errors'      => $errors,
            'metadata'    => [
                'basis'      => $basis,
                'rules'      => $rules,
                'expression' => $expression,
            ],
        ]);
    }

    /**
     * Validates the passed data against the passed validation.
     * This method is a static helper that combines the functionality of `self::validateAll()` and `self::validateOne()`.
     *
     * @param mixed|array<mixed>|Traversable<mixed> $data The data to validate.
     *      Can be a single value or an associative array of values.
     * @param string|Validation|array<string,string>|array<string,Validation> $validation The validation expression.
     *      Can be a single validation expression (see `self::validateOne()`), or an array of validation expressions for each data key (see `self::validateAll()`).
     * @param array<string,array<string,string|null>> $messages An associative array where key is a data key
     *      and value is an associative array where key is the rule name and value is the message.
     *      See `MAKS\Mighty\Rule::SCHEMA['@message']` for more info about placeholders.
     *      NOTE: Relevant only if `$data` is not a single value (`$validation` is an array).
     * @param array<string,string|null> $labels An associative array where key is a data key and value is the label.
     *      NOTE: Relevant only if `$data` is not a single value (`$validation` is an array).
     *
     * @return array<string,Result>|Result The validation results.
     *
     * @throws UnknownValidationRuleException If the rule is unknown.
     * @throws InexecutableRuleException If rule execution failed.
     * @throws InvalidBitwiseExpressionException If the bitwise expression resulting from the validation expression is invalid.
     */
    public static function validateData(mixed $data, Validation|string|array $validation, array $messages = [], array $labels = []): array|Result
    {
        static $validator = null;

        if ($validator === null) {
            $validator = new self();
        }

        $validate = is_array($validation)
            ? $validator->validateAll(...)
            : $validator->validateOne(...);

        $validator->setMessages($messages);
        $validator->setLabels($labels);
        $result = $validate($data, $validation);
        $validator->reset();

        return $result;
    }

    /**
     * Executes a single validation rule.
     *
     * @param string $name The name of the rule.
     * @param string $statement The statement of the rule.
     * @param mixed $input The input to pass to the rule.
     *
     * @return bool The result of the execution.
     *
     * @throws UnknownValidationRuleException If the rule is unknown.
     * @throws InexecutableRuleException If rule execution failed.
     */
    protected function executeRule(string $name, string $statement, $input): bool
    {
        $rule = $this->aliases[$name] ?? $name;
        $rule = $this->rules[$rule] ?? null;

        /** @var Rule|null $rule */
        if ($rule === null) {
            $names = array_merge(
                array_keys($this->rules),
                array_keys($this->aliases),
            );
            $keywords = Utility::transform($name, 'clean', 'lower');
            $keywords = explode(' ', $keywords);
            $keywords = array_filter($keywords, fn ($keyword) => strlen($keyword) > 1);
            $keywords = array_map(fn ($keyword) => preg_quote($keyword, '/'), $keywords);
            $keywords = array_reduce($keywords, fn ($carry, $item) => trim($carry . '|' . $item, '|'), '');
            $matches  = preg_grep("/({$keywords})/i", $names) ?: ['(no matches found)'];
            $matches  = implode('", "', $matches);

            throw new UnknownValidationRuleException(
                Utility::interpolate(
                    'Unknown rule: "{name}" is unknown. Did you mean: "{matches}"? If not, ' .
                    'check if the rule with given name was added or the default rules were loaded successfully',
                    compact('name', 'matches')
                )
            );
        }

        $result = $rule
            ->setStatement($statement)
            ->setInput($input)
            ->execute();

        return (bool)($result);
    }

    /**
     * Creates error messages for unsuccessful validations and injects the necessary variables into each message.
     *
     * @param array<string,bool> $validations The validations array. An associative array where key is the rule name and value is the result of the execution.
     *
     * @return array<string,string> An associative array where key is the rule name and value is the message.
     */
    protected function createErrorMessages(array $validations): array
    {
        $errors = array_filter($validations, fn ($validation) => $validation === false);

        /** @var array<string,string> $errors */
        // make a message for each validation and inject the necessary variables
        array_walk($errors, function (&$value, $name) {
            $rule    = $this->aliases[$name] ?? $name;
            $rule    = $this->rules[$rule];
            $current = $this->current;
            $message = $this->messages[$current][$name] ?? null;
            $label   = $this->labels[$current] ?? Utility::transform($current, 'title');

            $value = $rule->createErrorMessage(
                $message,
                $label ? ['@label' => $label] : null
            );
        });

        return $errors;
    }

    /**
     * Adds a new rule to the validator.
     *
     * @param Rule|array<string,string|array<mixed>|callable> $rule A rule object or a rule definition array
     *      (see `MAKS\Mighty\Rule::SCHEMA` for more info).
     *
     * @return static
     *
     * @throws InvalidRuleDefinitionException If the rule definition is invalid.
     */
    public function addRule(Rule|array $rule): static
    {
        if ($rule instanceof Rule) {
            $this->rules[(string)$rule->name()] = $rule;

            return $this;
        }

        $definition = $rule;

        try {
            ($validator = clone $this)
                ->setData($definition)
                ->setValidations([
                    '@name'         => $validator->validation()->required()->string()->between(2, 255)->matches('/^[A-Za-z]{1}[A-Za-z0-9._\-]{0,253}[A-Za-z0-9]{1}$/'),
                    '@arguments'    => $validator->validation()->null()->or()->group(fn ($validation) => $validation->required()->array()),
                    '@callback'     => $validator->validation()->null()->or()->group(fn ($validation) => $validation->required()->callable()),
                    '@parameters'   => $validator->validation()->null()->or()->group(fn ($validation) => $validation->required()->array()->min(1)),
                    '@comparison'   => $validator->validation()->null()->or()->group(fn ($validation) => $validation->required()->array()->count(3)),
                    '@comparison.1' => $validator->validation()->if('${@comparison.validations.null}', true, '===')->or()->group(fn ($validation) => $validation->string()->min(1)->max(3)),
                    '@message'      => $validator->validation()->null()->or()->string(),
                    '@description'  => $validator->validation()->null()->or()->string(),
                    '@example'      => $validator->validation()->null()->or()->string(),
                ])
                ->check();
        } catch (ValidatorThrowable $error) {
            throw new InvalidRuleDefinitionException(
                'Invalid rule definition: ' . $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $rule = new Rule($definition);

        return $this->addRule($rule);
    }

    /**
     * Adds a new rule alias to the validator.
     *
     * @param string $name Alias name.
     * @param string $rule Validation rule name.
     *
     * @return static
     *
     * @throws InvalidRuleAliasException If the alias name or validation rule name are invalid.
     */
    public function addAlias(string $name, string $rule): static
    {
        $name = trim($name);
        $rule = trim($rule);

        try {
            ($validator = clone $this)
                ->setData(compact('name', 'rule'))
                ->setValidations([
                    'name' => $validator->validation()->required()->string()->between(2, 255)->matches('/^[A-Za-z]{1}[A-Za-z0-9._\-]{0,253}[A-Za-z0-9]{1}$/'),
                    'rule' => $validator->validation()->required()->string()->between(2, 255)->matches('/^[A-Za-z]{1}[A-Za-z0-9._\-]{0,253}[A-Za-z0-9]{1}$/'),
                ])
                ->setLabels([
                    'name' => 'Alias name ($name)',
                    'rule' => 'Validation rule name ($rule)',
                ])
                ->check();
        } catch (ValidatorThrowable $error) {
            throw new InvalidRuleAliasException(
                'Invalid rule alias: ' . $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->aliases[$name] = $rule;

        return $this;
    }

    /**
     * Adds a new rule macro to the validator.
     *
     * @param string $name Macro name.
     * @param string|Validation $rules validation expression string or object.
     *
     * @return static
     *
     * @throws InvalidRuleMacroException If the macro name and/or validation expression are invalid.
     */
    public function addMacro(string $name, string|Validation $rules): static
    {
        $name  = sprintf('[%s]', trim(trim($name), '[]'));
        $rules = sprintf('(%s)', trim($rules instanceof Validation ? $rules->build() : $rules));

        try {
            ($validator = clone $this)
                ->setData(compact('name', 'rules'))
                ->setValidations([
                    'name'  => $validator->validation()->required()->string()->between(4, 255)->matches('/^\[[A-Za-z]{1}[A-Za-z0-9._\-]{0,251}[A-Za-z0-9]{1}\]$/'),
                    'rules' => $validator->validation()->required()->string()->min(4)->matches('/^\(.+\)$/'),
                ])
                ->setLabels([
                    'name'  => 'Macro name ($name)',
                    'rules' => 'Validation rules ($rules)',
                ])
                ->check();
        } catch (ValidatorThrowable $error) {
            throw new InvalidRuleMacroException(
                'Invalid rule macro: ' . $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->macros[$name] = $rules;

        return $this;
    }

    /**
     * Returns validator's available rules.
     *
     * @return array<string,Rule>
     */
    public function getRules(): array
    {
        return !empty($this->rules)
            ? $this->rules
            : $this->rules = $this->load(static::DEFAULT_RULES_PATH);
    }

    /**
     * Returns validator's available rules aliases.
     *
     * @return array<string,string>
     */
    public function getAliases(): array
    {
        return !empty($this->aliases)
            ? $this->aliases
            : $this->aliases = $this->load(static::DEFAULT_ALIASES_PATH);
    }

    /**
     * Returns validator's available rules macros.
     *
     * @return array<string,string>
     */
    public function getMacros(): array
    {
        return !empty($this->macros)
            ? $this->macros
            : $this->macros = $this->load(static::DEFAULT_MACROS_PATH);
    }

    /**
     * Loads the passed path as an array (`include $path`).
     *
     * @param string $path
     *
     * @return array<mixed>
     */
    private function load(string $path): array
    {
        $data = [];

        try {
            Exception::handle(static function () use ($path, &$data) {
                $data = require $path;
            });
        } catch (Throwable $error) {
            // throw $error;
            // fallback to an empty array
        }

        return (array)$data;
    }
}
