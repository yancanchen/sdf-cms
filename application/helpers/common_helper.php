<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// 参数解释
// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
/*function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $ckey_length = 4;

    // 密匙
    $key = md5($key ? $key : 'G)F#$*IUHCVG(IJCVBH(OIKNFGBDFG(OLOJR');

    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        // substr($result, 0, 10) == 0 验证数据有效性
        // substr($result, 0, 10) - time() > 0 验证数据有效性
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
        // 验证数据有效性，请看未加密明文的格式
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}*/

if (!function_exists('xml_convert')) {
    function xml_convert($str, $protect_all = FALSE)
    {
        $temp = '__TEMP_AMPERSANDS__';

        // Replace entities to temporary markers so that
        // ampersands won't get messed up
        $str = preg_replace("/&#(\d+);/", "$temp\\1;", $str);

        if ($protect_all === TRUE) {
            $str = preg_replace("/&(\w+);/", "$temp\\1;", $str);
        }

        $str = str_replace(array("&", "<", ">", "\"", "'", "-"),
            array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;", "&#45;"),
            $str);

        // Decode the temp markers back to entities
        $str = preg_replace("/$temp(\d+);/", "&#\\1;", $str);

        if ($protect_all === TRUE) {
            $str = preg_replace("/$temp(\w+);/", "&\\1;", $str);
        }

        return $str;
    }

    // xml编码
    function xml_encode($data, $encoding = 'utf-8', $root = "root")
    {
        $xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
        //$xml = '';
        $xml .= '<' . $root . '>';
        $xml .= data_to_xml($data);
        $xml .= '</' . $root . '>';
        return $xml;
    }

    function data_to_xml($data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($val) || is_object($val)) ? data_to_xml($val) : xml_convert($val);
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }
}

function inttomac($value)
{
    //	$value = "0474194512059883";
    $length = strlen($value);
    $macArr = "";
    for ($i = 0; $i < 9; $i = $i + 8) {
        $macArr [] = substr($value, $i, 8);
    }
    $macStr = "";
    foreach ($macArr as $value) {
        $macStr [] = strtoupper(sprintf("%06X", $value));
    }
    $macStr = $macStr [0] . $macStr [1];
    $leng = strlen($macStr);
    $mac = substr($macStr, 0, 2);
    for ($i = 2; $i < $leng; $i = $i + 2) {
        $mac = $mac . "-" . substr($macStr, $i, 2);
    }
    return $mac;
}

function mattoint($mac)
{
    $mac = str_replace("-", "", $mac);
    if (strlen($mac) != 12) {
        return 0;
    }
    $macArr [] = substr($mac, 0, 6);
    $macArr [] = substr($mac, 6, 6);
    if (!$macArr || count($macArr) != 2) {
        return false;
    }
    $macLong = '';
    foreach ($macArr as $v) {
        $macLong .= sprintf("%08d", hexdec($v));
    }
    return ($macLong);
}

function iptoint($ip)
{
    $iparr = explode(".", $ip);
    foreach ($iparr as &$value) {
        $value = sprintf("%03d", $value);
    }
    $ipint = implode($iparr, "");
    return $ipint;
}

function inttoip($ipint)
{
    $iparr = "";
    for ($i = 0; $i < 12; $i = $i + 3) {
        $iparr [] = ( int )substr($ipint, $i, 3);
    }
    $ip = implode(".", $iparr);
    return $ip;
}