<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoaDetail extends Model
{
    protected $table        =   'master_coa_detail';

    // public function CoaThird()
    // {
    //     return $this->hasMany('App\CoaThird', 'master_coa_detail_id','id');
    // }


    public function coathird()
    {
        return $this->hasMany('App\CoaThird', 'master_coa_detail_id','id');        
    }
    public function coajournal()
    {
        return $this->hasMany('App\CoaJournal', 'master_coa_detail_id','id');        
    }


    // public function coadetail()
    // {
    //     return $this->hasMany('App\CoaJournal');
    // }
}