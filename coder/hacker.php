<?php

namespace coder;

class hacker extends core
{

    private $pattern = '/windows/';
    private $web;

    /**
     * Брутфорс
     *
     * @param $ln
     * @param string $pat
     * @return string
     */
    private function bruteForce($ln, $pat = ''){

        $chars = "1234567890qwertyuiopasdfghjklzxcvbnm";

        if ( $ln == strlen($pat) ){
            $e = $this->hex2str($this->tryCoder($this->web, $this->str2hex($pat)));
            if (preg_match($this->pattern, $e) === 1)
                return $pat;
            return '';
        }

        for ($i = 0; $i < strlen($chars); ++$i)
            if ($r = $this->bruteForce($ln, $pat . $chars{$i}))
                return $r;

        return '';
    }

    /**
     * Запуск цикла перебора
     *
     * @param $start
     * @param $end
     * @return string
     */
    private function num($start,$end){
        for ($i=$start;$i<$end;$i++){
            $e = $this->hex2str($this->tryCoder( $this->web, $this->str2hex($i) ) );
            if ( preg_match($this->pattern, $e) === 1 ){
                return $i;
            }
        }
        return 'not found';
    }

    /**
     * Запуск брутфорса
     *
     * @param $length
     * @return string
     *
     */
    private function char($length){
        if ( $q = $this->bruteForce($length))
            return $q;
          else
            return 'not found';
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
    public function load($web, $start, $type = true, $end = 0){
        if ($end == 0 ){
            $end = $start;
            $start = 0;
        }

        $this->web = $web;
        if ($type){
            return $this->num($start,$end);
        } else {
            return $this->char($end);
        }

    }
}
