<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionOfficer extends Model
{
    //
    protected $primaryKey = 'inspectionOfficerID';

    protected $fillable = ["InsepectionOfficerID", "userID"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }

    public function inspection()
    {
        return $this->hasMany(Inspection::class, "inspectionOfficerID", "inspectionOfficerID");
    }
}
