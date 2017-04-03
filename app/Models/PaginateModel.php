<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaginateModel extends Model
{
	public $ilosc_rekordow = 0;
	public $ilosc_rekordow_na_stronie = 0;
	public $aktualna_strona = 0;

	public function prevent($slug)
	{
		 
		if(($this->aktualna_strona - 1) == 0)
		{
			return 'none';
		}
		elseif($this->aktualna_strona >= 1)
		{
			return $slug.'/?page='.($this->aktualna_strona - 1);
		}
		
	}

	public function next($slug)
	{

		$new = $this->aktualna_strona + 1;
		if($new <= $this->ilosc_rekordow)
		{
			return $slug.'/?page='.$new;
		}
		else
		{
			return 'none';
		}
	}

	public function numbers($slug)
	{
		$ilosc_stron = ceil($this->ilosc_rekordow/$this->ilosc_rekordow_na_stronie);
		$table = [];
		for($i=1;$i<=$ilosc_stron;$i++)
		{
			$table[] = ['slug'=>$slug.'/?page='.$i, 'number'=>$i];
			
		}
		return $table;
	}
    
    public function check()
    {
    	return ($this->ilosc_rekordow > $this->ilosc_rekordow_na_stronie) ? true : false;
    }
}
