<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Loại bỏ dấu tiếng Việt
     */
    public static function removeVietnameseTones($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        
        return $str;
    }

    /**
     * Tính độ tương đồng giữa 2 chuỗi (Levenshtein Distance)
     * Trả về % giống nhau (0-100)
     */
    public static function similarity($str1, $str2)
    {
        $str1 = mb_strtolower($str1);
        $str2 = mb_strtolower($str2);
        
        $len1 = mb_strlen($str1);
        $len2 = mb_strlen($str2);
        $maxLen = max($len1, $len2);
        
        if ($maxLen == 0) return 100;
        
        $distance = levenshtein($str1, $str2);
        return (1 - ($distance / $maxLen)) * 100;
    }

    /**
     * Tách chuỗi thành mảng từ khóa
     */
    public static function extractKeywords($str)
    {
        $str = self::removeVietnameseTones($str);
        $str = mb_strtolower($str);
        $str = preg_replace('/[^a-z0-9\s]/i', ' ', $str);
        $words = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);
        
        // Loại bỏ stop words (từ phổ biến không cần thiết)
        $stopWords = ['cua', 'cho', 'va', 'tren', 'duoi', 'trong', 'ngoai', 'voi', 'den', 'tu'];
        $words = array_diff($words, $stopWords);
        
        return array_values($words);
    }
}