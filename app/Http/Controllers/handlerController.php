<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class handlerController extends Controller
{
    //
    public function sortString(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'string' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        //get the string from the request
        $string = $request->string;
        //transform string into array
        $string_to_array = str_split($string);
        //define and initialize an empty array
        // $ascii_array = array_fill(0, 256, 0);

        // for ($i = 0; $i < count($string_to_array); $i++) {
        //     $ascii_array[ord($string_to_array[$i])]++;
        // }

        // print_r($ascii_array);
        // for ($k = 0; $k < count($ascii_array); $k++) {
        //     if ($ascii_array[$k] != 0) {
        //         for ($j = 0; $j < $i; $j++) {
        //             echo chr($k);
        //         }
        //     }
        // }
        // $result = '';
        // return response()->json([
        //     'sorted_string' => $ascii_array
        // ]);

        $upper_cases = [];
        $lower_cases = [];
        $numbers = [];

        foreach ($string_to_array as $val) {
            if ($val >= 'a' && $val <= 'z')
                array_push($lower_cases, $val);
            else if ($val >= 'A' && $val <= 'Z')
                array_push($upper_cases, $val);
            else
                array_push($numbers, $val);
        }

        sort($upper_cases);
        sort($lower_cases);
        sort($numbers);
        $i = 0;
        $j = 0;
        $k = 0;

        $sorted_array = [];
        sort($string_to_array);
        print_r($string_to_array);
        // for ($l = 0; $l < count($string_to_array); $l++) {
        //     if ($string_to_array[$l] >= 'a' && $string_to_array[$l] <= 'z' && count($lower_cases) > 0) {
        //         $string_to_array[$l] = $lower_cases[$i];
        //         $i++;
        //     } else if ($string_to_array[$l] >= 'A' && $string_to_array[$l] <= 'Z' && count($upper_cases) > 0) {
        //         $string_to_array[$l] = $upper_cases[$j];
        //         $j++;
        //     } else {
        //         $string_to_array[$l] = $numbers[$k];
        //         $k++;
        //     }
        // }

        // print_r($string_to_array);
    }
}