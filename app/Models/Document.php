<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $primaryKey = 'documentID';

    protected $fillable = ["documentID", "applicationID", "documentType", "documentName", "path"] ;

    public function application ()
    {
        return $this->belongsTo(Application::class, "applicationID", "applicationID");
    }
}
