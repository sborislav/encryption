<?php

namespace coder;

class plugin extends core
{
    private $_x, $_key;

    private $_request;

    private $_process = 0;

    /**
     * Запуск плагина
     */
    public function __construct()
    {
        // при запуске плагина вызывается функция для создания случайных чисел
        $this->randGenerate();
    }


    /**
     * Генерация случайных чисел
     */
    private function randGenerate(){

        $this->_x = random_int(1000000, 9999999);
        $this->_key = random_int(10000, 99999);
        //$this->_key = $this->getRandString(7);
    }

    /**
     * Запуск алгоритма проверки лицензии
     * @param array $data данные о программе
     */
    public function licenceCheck($data){
        if ( !empty($data) ){
            $data_string = implode(':', $data);
            $this->_request = "$this->_x:$data_string";
        }
        else
            $this->_request = $this->_x;

    }

    /**
     * Запрос
     * @return string
     */
    public function request(){
        return $this->tryCoder( $this->str2hex($this->_request),  $this->str2hex($this->_key) );
    }

    /**
     * Ответ
     * @param $string
     * @return string
     */
    public function response($string){

        switch ($this->_process){
            case 0: $this->_process++; return $this->tryCoder(  $string,  $this->str2hex($this->_key) );
            case 1: $this->_process++; return $this->tryCoder(  $string,  $this->str2hex($this->_key) );
            case 2: $this->_process++; return $this->tryCoder(  $string,  $this->str2hex($this->_key) );
            default: return 0;
        }
    }

    public function finish($code){

        if ( !empty($code) ){
            $code = $this->hex2str($code);
            if ( $code == $this->_x )
                return true;
            else
                return false;
        } else
            return false;
    }
}