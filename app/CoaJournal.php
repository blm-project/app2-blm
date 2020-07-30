<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoaJournal extends Model
{
    protected $table    =   'master_journal_detail';        


    public function coajournal()
    {
        return $this->belongsTo('App\CoaDetail', 'id','master_coa_detail_id');
    }

    //  public function coathird()
    // {
    //     return $this->hasMany('App\CoaJournal');
    // }


}