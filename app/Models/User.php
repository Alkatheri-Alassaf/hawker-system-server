<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $primaryKey = "userID";
    protected $fillable = ["userID", "firstName", "lastName", "email", "password", "role"];

    public function verficationOfficer()
    {
        return $this->hasOne(VerficationOfficer::class,"userID","userID");
    }

    public function inspectionOfficer()
    {
        return $this->hasOne(VerficationOfficer::class,"userID","userID");
    }

    public function hawker()
    {
        return $this->hasOne(Hawker::class,"userID","userID");
    }

    public function admin()
    {
        return $this->hasOne(Admin::class,"userID","userID");
    }
}
