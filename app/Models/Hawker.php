<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hawker extends Model
{
    //
    protected $primaryKey = 'hawkerID';

    protected $fillable = ["hawkerID", "userID", "nric", "address"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }

    public function application()
    {
        return $this->hasMany(Application::class, "hawkerID", "hawkerID");
    }

    public function licenses()
    {
        return $this->hasMany(License::class, "hawkerID", "hawkerID");
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, "hawkerID", "hawkerID");
    }
}
