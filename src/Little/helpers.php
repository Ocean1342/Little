<?php
/**
 * @param $var
 * @return void
 */
function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

/**
 * @param $var
 * @return void
 */
function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

}

