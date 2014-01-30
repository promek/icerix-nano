<?php

$debug = True; //use False to output erros to log file in tmp/nano-errors.log
$base_path='/';
$html_ext='htm'; //use htm or html 
$default_lang='en'; //use language filename without extention in lang directory.

$html_dir='html/'; //static html & templates dir
$lang_dir='lang/'; //languages dir 
$mod_dir='mod/'; //modules dir 
$tmp_dir = "tmp/"; //cache & log dir 

#urls rewrite  
$urls = array(
    'hello' => 'echo "Hello World!";', // http://127.0.0.1/hello say Hello World!
    'aboutus' => 'html("about");', // http://127.0.0.1/aboutus calls html/about.htm
    'contact' => 'include("mod/form.php");', // http://127.0.0.1/contact calls mod/form.php
    'i' => 'phpinfo();', // http://127.0.0.1/i calls phpinfo() function, you can call php functions directly
    '(.*)$' => 'html("main");' // in other cases call html/main.htm
)

?>
