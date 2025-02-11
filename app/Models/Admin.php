<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $primaryKey = 'adminID';

    protected $fillable = ["adminID","userID"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }
}
