<?php
namespace coder;


class core
{

    /**
     * Функция кодирования/декодирования
     *
     * @param string $mes сообщение в HEX формате
     * @param string $key Ключ в HEX формате
     * @return string
     */
    public function tryCoder( $mes , $key ){
        $mr = $this->hex2bin($mes);
        $mk = $this->hex2bin($key);

        if ( strlen($mr) > strlen($mk)  ){
            $whole = floor(strlen($mr) / strlen($mk));
            $distinction = strlen($mr) % strlen($mk);

            $newkey = '';
            for ($j=0;$j<$whole;$j+=1) $newkey .= $mk;
            if ( $distinction > 0 )
                $newkey .= substr($mk, 0, $distinction);

            $mk = $newkey;
            unset($newkey);
        }


        $bin = '';
        for ( $i = 0; $i < strlen($mr); $i++ )
            $bin .= ( $mr[$i] xor $mk[$i] ) ? '1' : '0';


        return $this->bin2hex($bin);
    }

    /**
     * Генератор случайнох символов
     * @param $length
     * @param string $alphabet
     * @return string
     */
    public function getRandString($length, $alphabet = '1234567890qwertyuiopasdfghjklzxcvbnm')
    {
        $alphabet = str_repeat($alphabet, (int)($length / mb_strlen($alphabet)) + 1);
        return mb_substr(str_shuffle($alphabet), 0, $length);
    }

    /**
     * Преобразование HEX в символы по таблице ASCII
     *
     * @param $hex
     * @return string
     */
    public function hex2str($hex) {
        $str = '';
        for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
        return $str;
    }

    /**
     * Преобразование символов в HEX по таблице ASCII
     *
     * @param $str
     * @return string
     */
    public function str2hex($str) {
        $hex = '';
        for($i=0;$i<strlen($str);$i+=1) $hex .= dechex(ord(substr($str,$i,1)));
        return $hex;
    }

    /**
     * Преобразование  HEX в BIN
     *
     * @param $hex
     * @return string
     */
    public function hex2bin($hex){
        $bin = '';
        for($i=0;$i<strlen($hex);$i+=2){
            $bin .= str_pad( decbin(hexdec(substr($hex,$i,2))) , 8, 0, STR_PAD_LEFT);
        }
        return $bin;
    }

    /**
     * Преобразование BIN в HEX
     *
     * @param $bin
     * @return string
     */
    public function bin2hex($bin){
        $hex = '';
        for($i=0;$i<strlen($bin);$i+=4){
            $hex .= dechex(bindec(substr($bin,$i,4)));
        }
        return $hex;
    }
}
