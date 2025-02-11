<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $id = "paymentID";
    protected $fillable = ["hawkerID", "applicationID", "amount", "cardNumber", "cardExpiryDate", "cardCVVNumber", "paymentStatus"];

    public function hawker()
    {
        return $this->belongsTo(Hawker::class, "hawkerID", "hawkerID");
    }

    public function application()
    {
        return $this->belongsTo(Application::class, "applicationID", "applicationID");
    }
}
