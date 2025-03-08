<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Auth;

class Encryption
{

    private static $defskey = "BAT4vA0q2z1B0c5F"; // EncryptionKey
    private static $chiperMethod = 'AES-256-CBC';

    public static function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return urlencode($data);
    }

    public static function safe_b64decode($string)
    {
        $data = urldecode($string);
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function encodeId($id, $module = null)
    {
        if (!$module) $module = time();
        if (Auth::user()) {
            return Encryption::encode($module . '_' . $id . '_' . Auth::user()->id);
        } else {
            return Encryption::encode($module . '_' . $id);
        }
    }

    public static function decodeId($id, $module = null)
    {
        $ids = explode('_', Encryption::decode($id));
        if (count($ids) == 3 && Auth::user()) {
            if (Auth::user()->id == $ids[2]) {
                if ($module) {
                    if (strcmp($module, $ids[0]) == 0) {
                        return $ids[1];
                    }
                } else {
                    return $ids[1];
                }
            }
        }
        if (count($ids) == 2) {
            if ($module) {
                if (strcmp($module, $ids[0]) == 0) {
                    return $ids[1];
                }
            } else {
                return $ids[1];
            }
        }
        die('Invalid Id! 401');
        //return null;
    }

    public static function encode($value, $skey = "")
    {
        if (!$value) {
            return false;
        }
        if (function_exists('mcrypt_module_open')) {
            if (strlen($skey) == 0) $skey = Encryption::$defskey;
            //echo 'ok- mcrypt enabled';
            $text = $value;
            $iv_size = @mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $crypttext = @mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
            return Encryption::safe_b64encode($crypttext);
        } else {
            return Encryption::safe_b64encode($value);
        }
    }

    public static function decode($value, $skey = "")
    {
        if (!$value) {
            return false;
        }
        if (strlen($skey) == 0) $skey = Encryption::$defskey;
        if (function_exists('mcrypt_module_open')) {
            //echo 'ok- mcrypt enabled';
            $crypttext = Encryption::safe_b64decode($value);
            $iv_size = @mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypttext = @mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
            return trim($decrypttext);
        } else {
            return Encryption::safe_b64decode($value);
        }
    }

    public static function dataEncode($value)
    {
        return Encryption::safe_b64encode($value);
    }

    public static function dataDecode($value)
    {
        return Encryption::safe_b64decode($value);
    }

    public static function processDataEncrypt($data)
    {
        if (!$data) {
            return false;
        }
        // get IV length
        $ivlen = openssl_cipher_iv_length(Encryption::$chiperMethod);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes($ivlen);
        // Generate encrypted data
        $encrypted_data = openssl_encrypt($data, Encryption::$chiperMethod, Encryption::$defskey, 0, $iv);

        // put iv into encrypted data to decrypt later
        return Encryption::safe_b64encode($encrypted_data . '::' . $iv);
    }

    public static function processDataDecrypt($data)
    {
        if (!$data) {
            return false;
        }

        $data_array = explode('::', Encryption::safe_b64decode($data), 2);
        // Validation for old data
        if (count($data_array) < 2) {
            return false;
        }
        $encrypted_data = $data_array[0];
        $iv = $data_array[1];
        // Generate decrypted data
        return openssl_decrypt($encrypted_data, Encryption::$chiperMethod, Encryption::$defskey, 0, $iv);
    }
}