<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace Hammerstone\Airdrop\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * Mimic the base_path helper from Laravel.
     *
     * @param string $path
     * @return string
     */
    public function basePath($path = '')
    {
        $dir = Str::before(base_path(), '/vendor');

        return $path ? $dir . '/' . $path : $dir;
    }
}