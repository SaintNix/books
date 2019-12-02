<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
session_start();

//УДАЛИТЬ
function pretty_print($in, $opened = true)
{
    if ($opened)
        $opened = ' open';
    if (is_object($in) or is_array($in)) {
        echo '<div style="cursor:pointer;">';
        echo '<details' . $opened . '>';
        echo '<summary>';
        echo (is_object($in)) ? 'Object {' . count((array)$in) . '}' : 'Array [' . count($in) . ']';
        echo '</summary>';
        pretty_print_rec($in, $opened);
        echo '</details>';
        echo '</div>';
    }
}
function pretty_print_rec($in, $opened, $margin = 10)
{
    if (!is_object($in) && !is_array($in))
        return;

    foreach ($in as $key => $value) {
        if (is_object($value) or is_array($value)) {
            echo '<details style="margin-left:' . $margin . 'px;" ' . $opened . '>';
            echo '<summary>';
            echo (is_object($value)) ? $key . ' {' . count((array)$value) . '}' : $key . ' [' . count($value) . ']';
            echo '</summary>';
            pretty_print_rec($value, $opened, $margin + 10);
            echo '</details>';
        } else {
            switch (gettype($value)) {
                case 'string':
                    $bgc = 'red';
                    break;
                case 'integer':
                    $bgc = 'green';
                    break;
            }
            echo '<div style="margin-left:' . $margin . 'px">' . $key . ' : <span style="color:' . $bgc . '">' . $value . '</span> (' . gettype($value) . ')</div>';
        }
    }
}

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/auth.php';
require_once 'config/config.php';
Route::start(); // запуск роутера