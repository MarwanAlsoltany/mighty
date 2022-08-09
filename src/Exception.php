<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty;

use Closure;
use Exception as CoreException;
use Throwable as CoreThrowable;
use MAKS\Mighty\Throwable;
use MAKS\Mighty\Support\Utility;

/**
 * Exception class.
 *
 * @package Mighty
 */
class Exception extends CoreException implements Throwable
{
    /**
     * Exception constructor.
     * {@inheritDoc}
     *
     * @param string $message Exception message.
     * @param int|string $code Exception code.
     */
    public function __construct(string $message, int|string $code = 0, ?CoreThrowable $previous = null)
    {
        parent::__construct($message, (int)$code, $previous);
    }

    /**
     * Returns a string representation of the exception object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return Utility::interpolate('{class}: {message} [Code: {code}] {eol}{trace}{eol}', [
            'class'   => static::class,
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
            'trace'   => $this->getTraceAsString(),
            'eol'     => PHP_EOL,
        ]);
    }

    /**
     * Throws an exception using the class this method was called on.
     *
     * @param string $message [optional] Exception message.
     * @param int|string $code [optional] Exception code. The code will be casted to an integer.
     * @param CoreThrowable|null $previous [optional] Previous exception.
     *
     * @return never
     *
     * @throws CoreException
     */
    public static function throw(string $message, int|string $code = 0, ?CoreThrowable $previous = null): never
    {
        throw new self($message, $code, $previous);
    }

    /**
     * Handles the passed callback in a safe context where PHP errors (and exceptions) result in exceptions that can be caught.
     *
     * @param Closure $callback The callback to execute.
     * @param string $message [optional] The exception message if the callback raised an error or throw an exception.
     * @param int $level [optional] The error level to handle. `E_*` constant, the behavior is unexpected if an arbitrary value is specified.
     *
     * @return void
     *
     * @throws CoreException
     */
    public static function handle(Closure $callback, ?string $message = null, int $level = E_ALL): void
    {
        static $handler = null;

        if ($handler === null) {
            $handler = function (int $code, string $message, string $file, int $line) {
                throw new \ErrorException($message, $code, E_ERROR, $file, $line);
            };
        }

        set_error_handler($handler, $level);

        try {
            $callback();
        } catch (CoreThrowable $error) {
            $message ??= Utility::interpolate('{method}() failed in {file} on line {line}', [
                '{method}' => __METHOD__,
                '{file}'   => $error->getFile(),
                '{line}'   => $error->getLine(),
            ]);
            $message = $message . ': ' . $error->getMessage();
            $code    = $error->getCode();

            static::throw($message, $code, $error);
        } finally {
            restore_error_handler();
        }
    }
}
