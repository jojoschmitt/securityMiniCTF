<?php

$string = "Dies ist ein edString, der keine große Aufgabe hat";
 
if($string!=str_replace("string","",$string)) echo "String ist enthalten<br>";

if(strpos($string,"string")!==false) echo "String ist enthalten<br>";

if(stripos($string,"sTring")!==false) echo "String ist enthalten<br>";

if(preg_match("/string/",$string)) echo "String ist enthalten";
