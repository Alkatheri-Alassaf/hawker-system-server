<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerficationOfficerController extends Controller
{
    //
    public function viewApplications(Request $request)
    {
        $applications = ApplicationController::getPendingApplications();
        if($applications)
            return response()->json(["status" => "success", "applications" => $applications]);
        return response()->json(["status" => "error", "applications" => "No Pending Applications Found"]);
    }

    public function reviewApplication(Request $request)
    {
        $applicationID = $request->applicationID;
        $documents = DocumentController::getDocumentsByApplicationID($applicationID);
        ApplicationController::setApplicationStatus($applicationID, "Under Reviewing");
        if ($documents->isEmpty())
            return response()->json(["status"=> "error"]);
        return response()->json(["status" => "success", "documents" => $documents]);

    }

    public function approveApplication(Request $request)
    {
        $applicationID = $request->applicationID;
        ApplicationController::setApplicationStatus($applicationID,"Waiting For Inspection");
        return response()->json(["status" => "success"]);
    }

    public function rejectApplication(Request $request)
    {
        $applicationID = $request->applicationID;
        ApplicationController::setApplicationStatus($applicationID,"Rejected");
        return response()->json(["status"=> "success"]);
    }
}
