<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoaThird extends Model
{
    protected $table    =   'master_coa_third';        


    public function coathird()
    {
        return $this->belongsTo('App\CoaDetail', 'id','master_coa_detail_id');
    }

    //  public function coathird()
    // {
    //     return $this->hasMany('App\CoaJournal');
    // }


}