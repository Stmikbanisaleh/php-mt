<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends CI_Controller {

	

	public function index() {
        
    }
    
    public function tes1(){
        for($i=1;$i<1000;$i++){
            $number = base_convert($i,10,10);
            $number = str_pad($number, 4, '0', STR_PAD_LEFT);
            echo " ".$number;
            echo "<br>";
          }
    }

    public function tes2(){
      

$waktuawal  = date_create('2018-02-21 09:00:00'); //waktu di setting

$waktuakhir = date_create(); //2019-02-21 09:35 waktu sekarang

$diff  = date_diff($waktuawal, $waktuakhir);

 

echo 'Selisih waktu: ';

echo $diff->y . ' tahun, ';

echo $diff->m . ' bulan, ';

echo $diff->d . ' hari, ';

echo $diff->h . ' jam, ';

echo $diff->i . ' menit, ';

echo $diff->s . ' detik, ';
    }
  
}
