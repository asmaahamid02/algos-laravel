<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        $upper_cases = array();
        $lower_cases = array();
        $numbers = array();
        $main_array = array();

        //split the array into upper cases, lower cases, and numbers
        foreach ($string_to_array as $val) {
            if ($val >= 'a' && $val <= 'z')
                array_push($lower_cases, $val);
            else if ($val >= 'A' && $val <= 'Z')
                array_push($upper_cases, $val);
            else
                array_push($numbers, $val);
        }

        //sort the new arrays
        sort($lower_cases);
        sort($upper_cases);
        sort($numbers);


        //get the count of the smallest array
        $count = count($lower_cases) > count($upper_cases) ? count($upper_cases) : count($lower_cases);

        //fill the main array alternatively (lower, upper ...)
        $i = 0;
        while ($count > 0) {
            array_push($main_array, $lower_cases[$i]);
            array_push($main_array, $upper_cases[$i]);
            $i++;
            $count--;
        }

        //get the remaining letters from upper cases
        while ($i < count($upper_cases)) {
            array_push($main_array, $upper_cases[$i]);
            $i++;
        }

        //get the remaining letters from lowers cases
        while ($i < count($lower_cases)) {
            array_push($main_array, $lower_cases[$i]);
            $i++;
        }

        //push the numbers to the main array
        for ($j = 0; $j < count($numbers); $j++) {
            array_push($main_array, $numbers[$j]);
        }

        //transform array to string
        $sorted_string = implode('', $main_array);

        return response()->json(
            [
                'status' => 'success',
                'message' => $sorted_string
            ],
            200
        );
    }

    public function placeValueInNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $number = $request->number;

        $negative = false;
        if ($number < 0) {
            $negative = true;
            $number = abs($number);
        }
        $arr = [];
        $count = 0;
        $total = 1;
        while ($number != 0) {
            //extract the extreme digit
            $remainder = $number % 10;
            //divide by 10 to remove the extracted digit
            $number = floor($number / 10);

            //get the place value of the digit
            $place_value = $total * $remainder * pow(10, $count);
            //chnage the sign if it is negative number
            $place_value = ($negative) ? $place_value * (-1) : $place_value;
            array_push($arr, $place_value);

            $count++;
        }
        //sort the digits values
        ($negative) ? sort($arr) : rsort($arr);
        return response()->json(
            [
                'status' => 'success',
                'message' => $arr
            ],
            200
        );
    }

    public function numbersToBinary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'string' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $string = $request->string;

        //replace the numbers with their binary code
        $replaced_str = preg_replace_callback('/[0-9]+/', function ($matches) {
            return decbin($matches[0]);
        }, $string);

        return response()->json(
            [
                'status' => 'success',
                'message' => $replaced_str
            ],
            200
        );
    }

    public function prefixNotation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expression' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $expression = $request->expression;

        //extract the operators 
        $operators = array();
        $operands = array();

        $expression_array = explode(" ", $expression);
        foreach ($expression_array as $val) {
            if ($val == '+' || $val == '-' || $val == '*' || $val == '/') {
                //push the operator at the end of the array
                array_push($operators, $val);
            } else {
                //push the operand at the beginning of the array
                array_unshift($operands, $val);
            }
        }

        print_r($operators);
        print_r($operands);
        $full_expression = '';
        while (count($operands) > 1) {
            $full_expression = '';
            //get the first operand (from top)
            $full_expression .= array_pop($operands);

            //get the operator if it is existed
            if (count($operators) > 0) {
                $full_expression .= array_pop($operators);
            }

            //get the next operand
            $full_expression .= array_pop($operands);
            array_push($operands, eval('return ' . $full_expression . ';'));
        }
        //get the value of the math. expression from the string
        // $result = eval('return ' . $full_expression . ';');
        return response()->json([
            'status' => 'success',
            'message' =>  $operands[0]
        ]);
    }
}