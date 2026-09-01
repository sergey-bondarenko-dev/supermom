<?php

/**
 * Read a required secret from the process environment.
 */
function theme_env(string $name): string
{
    $value = getenv($name);

    if ($value === false || trim($value) === '') {
        throw new RuntimeException("Required environment variable {$name} is not configured");
    }

    return $value;
}
