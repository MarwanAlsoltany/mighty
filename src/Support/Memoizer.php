<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Support;

use stdClass;
use WeakReference;

/**
 * Memoizer class.
 *
 * @package Mighty\Support
 */
final class Memoizer
{
    private const DEFAULT = '__default__';
    private const POOL    = '__pool__';
    private const NONE    = '__none__';

    /**
     * @var object
     */
    private static object $pools;

    /**
     * @var array<string,mixed>
     */
    private array $items;


    private function __construct()
    {
        // object should only be initialized using the "self::pool()" method
        // throw an exception if initialized with the "new" keyword (private constructor)

        $this->items = [];

        $pool = WeakReference::create($this);

        $this->set(self::NONE, null); // for coverage
        $this->set(self::POOL, $this->get(self::POOL, $pool));

        $this->clear();
    }

    public static function pool(?string $pool = null): self
    {
        $pool = $pool ?: self::DEFAULT;

        if (empty(self::$pools)) {
            self::$pools = new stdClass();
        }

        if (!isset(self::$pools->{$pool})) {
            self::$pools->{$pool} = new self();
        }

        return self::$pools->{$pool};
    }


    private function getItem(string $key, mixed $value = self::NONE): object
    {
        return $this->items[$key] ??= (object)[
            'key'   => $key,
            'value' => $value,
            'hits'  => 0,
        ];
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (!$this->has($key)) {
            return $default;
        }

        /** @var stdClass $item */
        $item = $this->getItem($key);

        $item->hits++;

        $value = $item->value !== self::NONE ? $item->value : $default;

        return $value;
    }

    public function set(string $key, mixed $value): self
    {
        /** @var stdClass $item */
        $item = $this->getItem($key);
        $item->value = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    public function forget(string $key): void
    {
        unset($this->items[$key]);
    }

    public function clear(): void
    {
        foreach ($this->items as $item) {
            $item->key !== self::POOL && $this->forget($item->key);
        }
    }
}
