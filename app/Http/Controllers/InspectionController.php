<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inspection;

class InspectionController extends Controller
{
    //
    public static function newInspection($applicatioID, $inspectionOfficerID, $inspectionDate)
    {
        $inspection = Inspection::create([
            "applicationID"=> $applicatioID,
            "inspectionOfficerID"=> $inspectionOfficerID,
            "inspectionDate"=> $inspectionDate
        ]);

        return $inspection ? $inspection : null;
    }

    public static function addInspectionReport($applicatioID, $reportPath)
    {
        Inspection::where("applicationID", $applicatioID)->update(["inspectionReportPath" => $reportPath]);
    }

    public static function getInspectionReport($applicatioID)
    {
        $reportPath = Inspection::where("applicationID", $applicatioID)->get("inspectionReportPath");
        return $reportPath ? $reportPath[0] : null;
    }
}
