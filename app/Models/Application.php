<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $primaryKey = 'applicationID';
    protected $fillable = ["applicationID", "hawkerID", "address", "status"];

    public function hawker()
    {
        return $this->belongsTo(Hawker::class, "hawkerID", "hawkerID");
    }

    public function document()
    {
        return $this->hasMany(Document::class, "applicationID", "applicationID");
    }

    public function inspection()
    {
        return $this->hasOne(Inspection::class, "applicationID", "applicationID");
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, "applicationID", "applicationID");
    }
}
