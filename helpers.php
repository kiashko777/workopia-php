<?php

/**
 *Get the base path
 *
 * @param string $path
 * @return string
 */

function basePath(string $path): string
{
    return __DIR__ . '/' . $path;
}

/**
 *Load a view
 *
 * @param string $name
 * @return void
 */

function loadView(string $name, array $data = [])
{
    $viewPath = basePath("views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View '{$name} not found!'";
    }
}

/**
 *Load a partial
 *
 * @param string $name
 * @return void
 */

function loadPartial(string $name)
{
    $partialPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "Partial '{$name} not found!'";
    }
}

/**
 *Inspect a value(s)
 *
 * @param mixed $value
 * @return void
 */

function inspect(mixed $value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

/**
 *Inspect a value(s) and die
 *
 * @param mixed $value
 * @return void
 */

function inspectAndDie(mixed $value)
{
    echo "<pre>";
    die(var_dump($value));
    echo "</pre>";
}

/**
 *Format salary
 *
 * @param string $salary
 * @return string Formatted Salary
 */

function formatSalary(string $salary): string
{
    return '$' . number_format($salary, 0, '.', ',');
}
