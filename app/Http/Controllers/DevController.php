<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DevController extends Controller
{
    public function str_to_urlFormat($str, $replace)
    {
        $char_repl = [',', ')', '(', '*', '&', '%', '+', '#', '$', '!', ' ', '’', '@', '|', ':', ';', '<', '>', '?', '/'];
        foreach ($char_repl as $item) {
            $str = str_replace($item, $replace, $str);
        }
        $ar = explode($replace, $str);
        $ar = array_filter($ar);
        $str = '';
        foreach ($ar as $key) {
            $str = $str . $replace . $key;
        }
        $str = strtolower($str);
        return substr($str, 1);
    }
}
