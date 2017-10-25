<?php

function makeword($length)
{
    $alphabet = '1234567890qwertyuiopasdfghjklzxcvbnm';
    $prefix = '';
    $words = array();
    if (strlen($prefix) == $length)
    {
        $words[] = $prefix;
        return;
    }
    for ($i = 0; $i < strlen($alphabet); $i++)
        makeword($prefix . $alphabet{$i});

    return $words;
}


/**
 * Функция злоумышленник
 *
 * @param bool $type Тип перебора 1 - числовой, 0 - символьный
 * @param string $web Переменная с HEX данными
 * @param int $start Начальное значение или длина, если не указан параметр $end
 * @param int $end Конечное значение. Только для числового перебора
 * @return string
 */
function hacker($type, $web, $start, $end = 0){
    $pattern = '/windows/';

    $core = new \coder\core();

    if ($type){
        // ключ состоит из цифр
        if ($end == 0 ){
            $end = $start;
            $start = 0;
        }
        for ($i=$start;$i<$end;$i++){
            $e = $core->hex2str($core->tryCoder( $web, $core->str2hex($i) ) );
            if ( preg_match($pattern, $e) === 1 ){
                return "$e  $i";
            }
        }
    } else {
        // ключ состоит из символов
        $words = makeword($start);
        foreach ($words as $word){
            $e = $core->hex2str($core->tryCoder( $web, $core->str2hex($word) ) );
            if ( preg_match($pattern, $e) === 1 ){
                return "$e  $word";
            }
        }
    }
    return 'not found';
}


