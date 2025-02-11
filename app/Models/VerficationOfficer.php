<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerficationOfficer extends Model
{
    //
    protected $primaryKey = 'verficationOfficerID';
    protected $fillable = ["verficationOfficerID", "userID"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }
}
