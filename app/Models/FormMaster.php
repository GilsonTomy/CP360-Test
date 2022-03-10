<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMaster extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected  $table = 'form_masters';

    public function form_details(){
        return $this->hasMany(FormDetail::class,'form_master_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
