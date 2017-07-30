<?php

Class CompareFile{

#The MIT License
###############################
#Copyright (c) 2016 Adam Berger
###############################
#Permission is hereby granted, free of charge, to any person obtaining a copy
#of this software and associated documentation files (the "Software"), to deal
#in the Software without restriction, including without limitation the rights
#to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
#copies of the Software, and to permit persons to whom the Software is
#furnished to do so, subject to the following conditions:
###############################
#The above copyright notice and this permission notice shall be included in
#all copies or substantial portions of the Software.
###############################
#THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
#IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
#FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
#AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
#LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
#OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
#THE SOFTWARE.
##############################


/**
 * @version 1.00
 * Porownaj Pliki
 * @author Adam Berger <ber34#o2.pl-->
 * Porównuje pliki z wybranego folderu z plikiem tekstowym, zawierającym podaną ścieżkę do pliku.
 * Pliki nie znajdujące się na liście usuwa z podanego folderu. 
 *  0 usuń pliki wskazane w pliku tekstowym
 *  1 zachowaj pliki wskazane w pliku tekstowym
 */

   public $file1;
   public $file2;
   private $numeric;
   public $error = array();
   private $Tab  = array();
   private $Tab1 = array();

     /**
      *  _construct( $file1, $file2, $numeric )
      *  string $file1 lokalizacja pliku tekstowego
      *  string $file2 lokalizacja plików
      *  int $numeric wybór zadania
      *  return null
      *  0 usuń pliki wskazane w pliku tekstowym
      *  1 zachowaj pliki wskazane w pliku tekstowym
      */

      public function __construct( $file1, $file2, $numeric ){

             $this->file1 = $file1;
             $this->file2 = $file2;
			 
	   if(is_numeric($numeric)){
				 
		$this->numeric = $numeric; 
				 
		 }else{
		   
		$this->error[] = " Podaj prawidłowy parametr Numerik "; 
			
	   }	 
         }

   /**
   * string $file1
   * sprawdzenie czy plik znajduje się w podanej ścieżce 
   * return boolea
   */

      private function check_dir($file){
     
	 //if(file_exists($file1) && is_dir($file1)){
       if(file_exists($file)){
		   
         return true;
		 
         }else{
	   $this->error[] = " Błędna lokalizacja pliku lub folderu ";
          // throw new Exception(" Błędna lokalizacja pliku lub folderu ");
         return false;

          }
       }

        /**
          * plik tekstowy
          * obiekt string $this->file1
          * obiekt array() $this->error
          * return array()
          */

       public function load_text_file(){

           if($this->check_dir($this->file1)){   
                if(is_array(file($this->file1))){
		     // czyścimy trim ze śmieci
		     $this->Tab = explode(",",implode(',', array_map('trim', file($this->file1))));
                  }else{
                    $this->error[] =" Tablica jest pusta ";
                   }

              }else{
	
               //throw new Exception("Błędna lokalizacja pliku tekstowego");
                 $this->error[] =" Błędna lokalizacja pliku tekstowego ";

              }
        }

     /**
      * obiekt string  $this->file1
      * obiekt array() $this->error
      * obiekt array() $this->Tab1
      */

      public function load_dir(){
           if($this->check_dir($this->file2)){
                // $dir  = dirname(__FILE__) .'/pliki';
	      $this->Tab1 = array_diff(scandir($this->file2), array('..', '.'));
                // $this->Tab1 = scandir($this->file2);

              }else{
               //throw new Exception("Błędna lokalizacja pliku tekstowego");
              $this->error[]  =" Błędna lokalizacja pliku tekstowego ";
           }
        }

   /**
    *
    * obiekt array() $this->Tab1
    * return array() $zle_usun
    */

       public function compare_file(){

        if(is_array($this->Tab1)){
		//print_r($this->Tab1);
		 //Var_dump($this->Tab);
		// Var_dump($this->Tab1);
		
         foreach($this->Tab1 as $spr){
		 
		if(in_array( $spr, $this->Tab )){
                  // echo $spr;
                    $dobre[] = $spr;
		// numeric 0 
		if($this->numeric == 0){
		//  $wyn  = array_merge($this->Tab[0], $this->Tab1);        
                         //  $wyn1 = array_unique( $wyn );
		 if($this->check_dir($this->file2)){
                     unlink($this->file2."/".$spr);
				      }
				   }
                }else{
				// numeric 1 
		if($this->numeric == 1){
                   $zle_usun[] = $spr;
		// Usuwamy pliki zbędne
         //array_map( "unlink", glob(dirname(__FILE__) .'/pliki/*'.$plik.'.clu') );
		 if($this->check_dir($this->file2)){
                     unlink($this->file2."/".$spr);
				      }
				 }
                }
				 
			 
		 }
             } else {
           $this->error[] =" Tablica jest pusta ";
          }
          
         if(!empty($dobre) || !empty($zle_usun)){
			
          $this->error[] ="Usunięto Wszystko OK  "; 

		 }else{
		// throw new Exception("Tablica jest pusta");
		 $this->error[] =" Usunięto ";
		   }     
        }

     /**
      * obiekt string $this->error
      * return obiekt string $this->error
      */

      public function Error(){

          if(!empty($this->error)){
			  
	     return $this->error;				   

            }
	  }
}
