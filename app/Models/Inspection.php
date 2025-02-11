<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    //
    protected $primaryKey = "inspectionID";

    protected $fillable = ["applicationID","inspectionOfficerID","inspectionDate","inspectionReportPath"];

    public function application()
    {
        return $this->belongsTo(Application::class, "applicationID", "applicationID");
    }

    public function inspectionOfficer()
    {
        return $this->belongsTo(InspectionOfficer::class,"inspectionOfficerID", "inspectionOfficerID");
    }
}
