<?php

require_once(dirname(__FILE__) ."/ClasaSprawdzPliki.php");


/// do pliku
// plik z plikami do usunięcia
$file1 = dirname(__FILE__) ."/test-pliki.txt";
// folder z plikami do porównania
$file2="c:/test";

// $dir    = dirname(__FILE__) .'/pliki';

// 0 usuń pliki wskazane w pliku tekstowym
// 1 zachowaj pliki wskazane w pliku tekstowym

  $pliki = new CompareFile($file1, $file2, 0);
 
  $pliki->load_text_file();
  $pliki->load_dir();
  $pliki->compare_file();
  
  // Wypisujemy błędy
   echo $pliki->Error()[0];



