<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InspectionOfficer;

class InspectionOfficerController extends Controller
{
    //
    public function viewApplicationS(Request $request)
    {
        $userID = $request->userID;
        // return response()->json(["status"=> "success", "userID"=> $userID]);

        $inspectionOfficer = InspectionOfficer::where("userID", "=", $userID)->get();
        $inspectionOfficerID = $inspectionOfficer[0]->inspectionOfficerID;
        $application = ApplicationController::getVerifiedApplications();
        return response()->json(["status"=> "success", "applications" => $application, "inspectionOfficerID" => $inspectionOfficerID]);
    }

    public function sechdualInspection(Request $request)
    {
        $applicationID = $request->input("applicationID");
        $inspectionDate = $request->input("inspectionDate");
        $inspectionOfficerID = $request->input("inspectionOfficerID");

        $inspection = InspectionController::newInspection(
        $applicationID,
        $inspectionOfficerID,
        $inspectionDate);

        if($inspection)
        {
            ApplicationController::setApplicationStatus($applicationID, "Inspection is set on $inspectionDate");
            return response()->json(["status"=> "success", "inspection"=> $inspection]);
        } else
        return response()->json(["status" => "error"]);
    }

    public function submitInspectionReport(Request $request)
    {
        $inspectionReport = $request->file("inspectionReport");
        $applicationID = $request->input("applicationID");

        $path = DocumentController::newDocument($applicationID, $inspectionReport, "Inspection Report");
        InspectionController::addInspectionReport($applicationID, $path);
        ApplicationController::setApplicationStatus($applicationID, "Waiting For Approval");
        return response()->json(["status"=> "success", "message" => "File Uploaded Successfully"]);
    }
}
