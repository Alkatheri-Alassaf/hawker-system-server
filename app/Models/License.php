<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    //
    protected $primaryKey = 'licenseID';

    protected $fillable = ["licenseID", "hawkerID", "issueDate", "expirationDate", "status"];

    public function hawker()
    {
        return $this->belongsTo(Hawker::class, "hawkerID", "hawkerID");
    }
}
