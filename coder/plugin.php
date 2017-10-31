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
    public  function __construct()
    {
        // при запуске плагина вызывается функция для создания случайных чисел
        $this->randGenerate();
    }

    /**
     * Генерация случайных чисел
     */
    private function randGenerate(){

        $this->_x = random_int(1000000, 9999999);
      ///  $this->_key = random_int(100000, 999999);
        $this->_key = $this->getRandString(4);
       // $this->_key = 'ilec27sw';
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

        echo "x: $this->_x <br>";
        echo "key: $this->_key <br>";
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
            case 0:
                $this->_process++;
                if ( $string == $this->request() ) { echo $this->finish(); exit; }
                return $this->tryCoder(  $string,  $this->str2hex($this->_key) );
            case 1:
                $this->_process++;
                return $this->tryCoder(  $string,  $this->str2hex($this->_key) );
            case 2:
                $this->_process++;
                return $this->hex2str($this->tryCoder(  $string,  $this->str2hex($this->_key) ) );
            default: return 0;
        }
    }

    public function finish($code = null){

        if ( !empty($code) ){

            if ( $code == $this->_x )
                return 'Лицензия подтверждена';
            else
                return 'Ошибка лицензии';
        } else
            return 'Ошибка лицензии';
    }
}
