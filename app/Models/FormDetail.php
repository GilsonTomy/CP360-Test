<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected  $table = 'form_details';

    public function form_master(){
        return $this->belongsTo(FormMaster::class,'form_master_id');
    }
}
