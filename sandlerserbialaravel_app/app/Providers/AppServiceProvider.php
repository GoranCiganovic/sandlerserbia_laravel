<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Input;
use DateTime;
use Exception;           


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Add this custom validation rule.
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha, spaces.and  hyphens
            // without hyphens use: /^[\pL\s]+$/u.
            return preg_match('/^[\pL\s-]+$/u', $value); 
        });

        Validator::extend('numeric_spaces', function ($attribute, $value) {
            // This will only accept numbers , + and spaces. 
            return preg_match('/(^[0-9+ ]+$)+/', $value); 
        });
 
        Validator::extend('valid_method', function ($attribute, $value){
            //Validata custom statistics methods
            $methods_array=['conversation_ratio','closing_ratio','sandler_traffic','disc_devine_traffic','total_traffic'];
            return in_array($value, $methods_array);
        });

        Validator::extend('less_equal_then', function ($attribute, $value, $parameters) {
            // Returns true if value is less or equal then parametar
            $other = Input::get($parameters[0]);
            return isset($other) and intval($value) <= intval($other);
        });

        Validator::extend('advance_zero', function ($attribute, $advance, $parameters) {
           // Returns True in case Payment is 0 and Advance is Equal to Contract Value
            $payments = Input::get($parameters[0]);
            $contract_value =Input::get($parameters[1]);
           if(intval($payments) == 0 && intval($advance) != intval($contract_value)){
                return false;
           }else{
                return true;
           }
        });

        Validator::extend('payments_zero', function ($attribute, $payments, $parameters) {
            // Returns True if the Payments or Advance is not 0
            $advance = Input::get($parameters[0]);
            return intval($payments) != 0 or intval($advance) != 0;
        });

        Validator::extend('before_today', function ($attribute, $value) {
            // Accepts date before today. 
            try {
                $today = new DateTime();
                $input_date = new DateTime($value);
                return $input_date->format('Y-m-d') < $today->format('Y-m-d');
            } catch (Exception $e) {
                return false;
            }
        });

        Validator::extend('before_and_today', function ($attribute, $value) {
            // Accepts date before an today. 
            try {
                $today = new DateTime();
                $input_date = new DateTime($value);
                return $input_date->format('Y-m-d') <= $today->format('Y-m-d');
            } catch (Exception $e) {
                return false;
            }
        });

        Validator::extend('after_today', function ($attribute, $value) {
            // Accepts date after today.
            try {
                $today = new DateTime();
                $input_date = new DateTime($value);
                return $input_date->format('Y-m-d') > $today->format('Y-m-d');
            } catch (Exception $e) {
                return false;
            }
        });

        Validator::extend('after_and_today', function ($attribute, $value) {
            // Accepts date after and today.
            try {
                $today = new DateTime();
                $input_date = new DateTime($value);
                return $input_date->format('Y-m-d') >= $today->format('Y-m-d');
            } catch (Exception $e) {
                return false;
            }
            
        });

        Validator::extend('after_or_equal', function ($attribute, $value, $parameters) {
            // Accepts date after or equal  parameter date
            try {
                $other = Input::get($parameters[0]);
                $other_date = new DateTime($other);
                $input_date = new DateTime($value);
                return isset($other) and $input_date->format('Y-m-d') >= $other_date->format('Y-m-d');
            } catch (Exception $e) {
                return false;
            }
        });
        Validator::replacer('after_or_equal', function($message, $attribute, $rule, $parameters){
            // Replaces name of attribute
            if($parameters[0]=='contract_date'){
                $parameter='Datum Ugovora';
            }else if($parameters[0]=='start_date'){
                $parameter='Datum početka';
            }else{
                $parameter=$parameters[0];
            }
            return str_replace(':date', $parameter, $message);
        });


        Validator::extend('before_or_equal', function ($attribute, $value, $parameters) {
            // Accepts date before or equal  parameter date (if parameter is not empty)
            try {
                $other = Input::get($parameters[0]);
                if($other){
                    $other_date = new DateTime($other);
                    $input_date = new DateTime($value);           
                    return isset($other) and $input_date->format('Y-m-d') <= $other_date->format('Y-m-d');
                }else{
                    return true;
                }
            } catch (Exception $e) {
                return false;
            }
        });
        Validator::replacer('before_or_equal', function($message, $attribute, $rule, $parameters){
            // Replaces name of attribute
            if($parameters[0]=='start_date'){
                $parameter='Datum početka';
            }else if($parameters[0]=='end_date'){
                $parameter='Datum završetka';
            }else{
                $parameter=$parameters[0];
            }
            return str_replace(':date', $parameter, $message);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}


