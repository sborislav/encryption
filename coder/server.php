<?php

namespace coder;

class server  extends core
{
    private $_key2, $_key21;

    private $_code;

    private $_license_arr = [
      '124.65.87.12' => true,
    ];

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
        $this->_key2 = random_int(1000000, 9999999);
        $this->_key21 = random_int(1000000, 9999999);
    }


    /**
     * Запуск алгоритма проверки лицензии
     * @param string $data данные о программе
     * @return string
     */
    private function licenceCheck($data){
        $array = explode(':', $data);
        $this->_code = $array[0];
        if ( array_key_exists($array[1], $this->_license_arr) ){
            return $this->_code;
        } else {
            return '0';
        }
    }


    /**
     * Получение данных от плагина
     * @return string
     */
    public function request($string){

        switch ($this->_process){
            case 0:
                $this->_process++;
                return $this->tryCoder(  $string,  $this->str2hex($this->_key2) );
            case 1:
                $this->_process++;
                $data = $this->hex2str($this->tryCoder( $string,  $this->str2hex($this->_key2)) );
                $code = $this->licenceCheck($data);
                return $this->tryCoder( $this->str2hex( $code),  $this->str2hex($this->_key21) );
            case 2:
                $this->_process++;
                return $this->tryCoder(  $string,  $this->str2hex($this->_key21) );
            default: return 0;
        }
    }

}