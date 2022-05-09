<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Core\Packages\Setting\Setting;


if (!function_exists('base64')) {
    function base64($imgUrl){

        $folder = 'uploads/api';

        $path   = $imgUrl;
        $type   = '.jpg';
        $imgname = md5(rand() * time()) . '.' . $type;

        // Get new name of image Url & Path of folder to save in it
        $fname = $folder.'/'.$imgname;
        $img = Image::make($path);

        // End of this proccess
        $img->save($fname);

        return $fname;
    }

}

if (!function_exists('supportedLocales')) {
    function supportedLocales($locales)
    {
        return array_intersect_key(config('core.available-locales'), array_flip($locales));
    }
}

if (!function_exists('supprtedLocalesApi')) {
    function supprtedLocalesApi($locales)
    {
        $data = [];
        foreach (supportedLocales($locales) as $key => $value) {
            unset($value["script"]);
            $value["code"] =$key;
            $data[]= $value;
        }
        return $data;
    }
}

// Get Setting Values
if (!function_exists('setting')) {

    function setting($key,$index = null,$default = null) {
        $value = null;
        $data = Setting::get($key);
        if (!is_null($index)){

          if ($data) {
            $value = array_key_exists($index,$data) ? $data[$index] : $default;
          }

        }else{

          $value = $data ?? $default;

        }

        return $value ?? $default;
    }
}

if (! function_exists('color_theme')) {

    function color_theme($category){
        return $category ? $category->color : '';
    }

}

if (! function_exists('checkRoutesActiveVersion')) {

    /**
     * @param $version
     * @return string
     */
    function checkRoutesActiveVersion($version){
        return in_array($version,config('core.route-versions.api.active-versions')) ? $version.'/' : Hash::make(Str::random(6));
    }

}

if (! function_exists('setValidationAttributes')) {

    function setValidationAttributes(array $attributes,$local = 'ar'){
       if(config('core.validation-attributes.'.$local)){
            $attributes += (array)config('core.validation-attributes.'.$local);
           Illuminate\Support\Facades\Config::set('core.validation-attributes.'.$local, $attributes);
       }
    }

}

// Active Dashboard Menu
if (! function_exists('active_menu')) {
    function active_menu($routeNames){
        $routeNames = (array) $routeNames;

        if(in_array(Illuminate\Support\Facades\Route::currentRouteName() , $routeNames)){
            return 'active';
        }

        foreach ($routeNames as $routeName) {
            return (strpos(Illuminate\Support\Facades\Route::currentRouteName(), $routeName) == 0) ? '' : 'active';
        }
    }
}

if (! function_exists('active_slide_menu')) {
    function active_slide_menu($routeNames){
        $response = [];
        foreach ((array)$routeNames as $name){
            array_push($response , active_menu($name));
        }

        return in_array('active' , $response) ? 'true' : 'false';
    }
}

if (! function_exists('active_profile')) {

    function active_profile($route){
        return (Route::currentRouteName() == $route) ? 'active' : '';
    }

}

// GET THE CURRENT LOCALE
if (! function_exists('locale')) {

    function locale() {
        return app()->getLocale();
    }

}

// CHECK IF CURRENT LOCALE IS RTL
if (! function_exists('is_rtl')) {

    function is_rtl($locale = null) {

        $locale = ($locale == null) ? locale() : $locale;

        if (in_array($locale, config('rtl_locales'))) {
          return 'rtl';
        }

        return 'ltr';
    }

}


if (! function_exists('slugfy')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
     function slugfy($string, $separator = '-')
     {
         $url = trim($string);
         $url = strtolower($url);
         $url = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $url);
         $url = preg_replace('/\s+/', ' ', $url);
         $url = str_replace(' ', $separator, $url);

         return $url;
     }
}


// if (! function_exists('path_without_domain')) {
//     /**
//      * Get Path Of File Without Domain URL
//      *
//      * @param string $locale
//      */
//     function path_without_domain($path)
//     {
//         return parse_url($path, PHP_URL_PATH);
//     }
// }


if (! function_exists('path_without_domain')) {
    /**
     * Get Path Of File Without Domain URL
     *
     * @param string $locale
     */
    function path_without_domain($path)
    {
        $url = $path;
        $parts = explode("/",$url);
        array_shift($parts);
        array_shift($parts);
        array_shift($parts);
        $newurl = implode("/",$parts);

        return $newurl;
    }
}

if (! function_exists('int_to_array')) {
    /**
     * convert a comma separated string of numbers to an array
     *
     * @param string $integers
     */
    function int_to_array($integers)
    {
        return array_map("intval", explode(",", $integers));
    }
}


if (!function_exists('combinations')) {

    function combinations($arrays, $i = 0) {

        if (!isset($arrays[$i])) {
            return array();
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }

}


if (!function_exists('htmlView')) {
    /**
     * Access the OrderStatus helper.
     */
     function htmlView($content)
     {
         return
         '<!DOCTYPE html>
           <html lang="en">
             <head>
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="css/bootstrap.min.css" rel="stylesheet">
               <!--[if lt IE 9]>
                 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
               <![endif]-->
             </head>
             <body>
               '.$content.'
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
               <script src="js/bootstrap.min.js"></script>
             </body>
           </html>';
     }
}


if (! function_exists('currency')) {
    /**
     * The Current currency
     *
     * @param string $currency
     */
    function currency($price)
    {
        if (session()->get('currency'))
            return convertCurrency($price) .' '. currentCurrency();

        return convertCurrency($price) . ' ' . currentCurrency();
    }
}

if (! function_exists('convertCurrency')) {
    /**
     * The Convert Price
     *
     * @param string $price
     */
    function convertCurrency($price)
    {
        if (session()->get('currency'))
            return ( round( ($price * session()->get('currency')['rate']) /5 ) * 5 );

        if (Request::header('Currency-Rate'))
            return ( round( ($price * \Request::header('Currency-Rate') ) /5 ) * 5 );

        return round($price);
    }
}

if (! function_exists('currentCurrency')) {
    /**
     * The Current currentCurrency
     *
     * @param string $currentCurrency
     */
    function currentCurrency()
    {
        if (session()->get('currency'))
            return session()->get('currency')['code'];

        if ( Request::header('Currency-Rate') )
            return \Request::header('Currency-Code');

        return setting('default_currency');
    }
}

if (!function_exists('ajaxSwitch')) {

    function ajaxSwitch($model, $url, $switch = 'status', $open = 1, $close = 0)
    {
        return view('apps::dashboard.components.ajax-switch', compact('model', 'url', 'switch', 'open', 'close'))->render();
    }
}

if (!function_exists('getClientType')) {

    function getClientType($object)
    {
        $class_namespace = get_class($object);
        $namespace_array_paths = explode('\\',$class_namespace);
        return strtolower($namespace_array_paths[count($namespace_array_paths) - 1]);
    }
}


function active_class($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function darkTheme() {
    return auth()->check() && auth()->user()->theme == 'dark' ? 'dark' : is_rtl();
}

function sidebarTheme() {
    return auth()->check() ? auth()->user()->sidebar : 'light';
}

function horizontal() {
    return auth()->check() ? auth()->user()->horizontal : false;
}

//areas check functions


if (!function_exists('checkAreaQuery')) {

    function checkAreaQuery($latitude,$longitude) {
        return '*, ( 6367 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) *
                    cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) *
                    sin( radians( latitude ) ) ) ) AS distance';
    }
}
