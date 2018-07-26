<?php

namespace App\Helpers;
use Request;
use App\DocNumber;

class GenDocNumber {

    public static function genDocnumber($docname, $department = null)
    {
        if (empty($docname)){
            throw new \App\Exceptions\GenDocNumberException('Error Reference doc name,please contact admin.');
        }

        $number = DocNumber::where('short_name' ,$docname)->first();
        //check max number
        if ($number->next_num > $number->end_num){
            throw new \App\Exceptions\GenDocNumberException('Maximum number,please contact admin.');
        }
        $current_year = date('Y');
        $current_month = date('m');
        //$D_FORMAT = $number->doc_format;

        $D_YEAR = $number->doc_year;
        $D_MONTH = $number->doc_month;
        $D_DELI = $number->delimiter;
        $D_PREFIX = $number->prefix;
        $D_SUFFIX = $number->suffix;
        $D_DIGIT = $number->digit_num;

        if ($number->month_reset_num == 'Y'){
            if ($current_month > $D_MONTH){
                $number->current_num = $number->start_num - 1;
                $number->next_num = $number->start_num;
                $number->doc_month = $current_month;
                $D_MONTH = $number->doc_month;
            }
        }

        if ($number->year_reset_num == 'Y'){
            if ($current_year > $D_YEAR){
                $number->current_num = $number->start_num - 1;
                $number->next_num = $number->start_num;
                $number->doc_year = $current_year;
                $number->doc_month = $current_month;
                $D_YEAR = $number->doc_year;
                $D_MONTH = $number->doc_month;
            }
        }

        $D_NUM = str_pad($number->next_num, $D_DIGIT, "0", STR_PAD_LEFT);
        $number->current_num = $number->next_num;
        $number->next_num = $number->next_num + 1;
        $number->save();

        /*
         {DELI}=delimiter
         {YY}=year
         {MM}=month
         {NN}=number
         {DEP}=department
         */
        $D_RESULT = $number->doc_format;

        $D_RESULT = str_replace("{NN}", $D_NUM ,$D_RESULT);
        $D_RESULT = str_replace("{DELI}", $D_DELI ,$D_RESULT);
        $D_RESULT = str_replace("{YY}", $D_YEAR ,$D_RESULT);
        $D_RESULT = str_replace("{MM}", $D_MONTH ,$D_RESULT);
        $D_RESULT = str_replace("{DEP}", $department ,$D_RESULT);
        

        if (!empty($D_PREFIX)){
            $D_RESULT = $D_PREFIX . $D_RESULT;
        }
        if (!empty($D_SUFFIX)){
            $D_RESULT = $D_RESULT . $D_SUFFIX;
        }

        return $D_RESULT;
    }
}