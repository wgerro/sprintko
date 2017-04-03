<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cookie;

class VisitsModel extends Model
{
	static public $actual_date;
    static public $array;

	public function __construct($get=null){
		self::$actual_date = date('Y-m-d', time() + 7200);
        self::$array = $get;
	}

    protected $table = 'visits';
    protected $fillable = [
        'updated_at',
        'numbers'
    ];
    public $timestamps = false;

    /*
    * VISITS CHECK COOKIES
    */
    public static function check(){
    	$minutes = (60 * 24) + 120;
    	if(!Cookie::get('visit'))
    	{
    		Cookie::queue('visit', true , $minutes);
    		self::set(self::$actual_date);
    	}

    	return true;
    }

    /*
    * VISITS SET ADD OR UPDATE DATA 
    */
    public static function set($date){
    	$check = VisitsModel::where('updated_at', $date)->first();
    	if(is_null($check))
    	{
    		$visit = new VisitsModel();
	    	$visit->updated_at = date('Y-m-d', time() + 7200);
	    	$visit->numbers = 1;
	    	$visit->save();
    	}
    	elseif(!is_null($check))
    	{
    		$check->numbers = $check->numbers + 1;
    		$check->save();
    	}
    }

    /*
    * VISITS GET
    */
    public static function getVisits(){
        return collect(self::$array)->sortBy('id');
    }
    /*
    * COUNT DAYS
    */
    public static function countDay(){
    	$count = self::getVisits()->where('updated_at', self::$actual_date )->count();
        return $count > 0 ? self::getVisits()->where('updated_at', self::$actual_date )->first()->numbers : 0;
    }

    /*
    * GROUP MONTH
    */
    public static function groupMonth(){
        $collect = self::getVisits()->groupBy(function ($item, $key) {
            return explode('-',$item->updated_at)[0].'-'.explode('-',$item->updated_at)[1];
        });

        return $collect;
        
    }

    /*
    * GET MONTH
    */
    public static function getMonth(){
        $year = explode('-',self::$actual_date)[0];
        $month = explode('-',self::$actual_date)[1];
        $year_month = $year.'-'.$month;

        return isset(self::groupMonth()[$year_month]) ? self::groupMonth()[$year_month] : [];
    }

    /*
    * COUNT GROUP MONTH - actual date
    */
    public static function countMonth(){
        return count(self::getMonth()) > 0 ? self::getMonth()->sum('numbers') : 0;
    }

    /*
    * GROUP YEAR
    */
    public static function groupYear(){
    	return $collect = self::getVisits()->groupBy(function ($item, $key) {
		    return explode('-',$item->updated_at)[0];
		});
    }

    /*
    * GET YEARS
    */
    public static function getYear(){
    	$year = explode('-',self::$actual_date)[0];
    	return self::groupYear()[$year];
    }

    /*
    * COUNT GROUP YEAR - actual date
    */
    public static function countYear(){
    	return self::getYear()->sum('numbers');
    }

}
