<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hawker;

use Exception;

class HawkerController extends Controller
{
    //
    public function getHawkerID(Request $request)
    {
        $userID = $request->userID;
        $hawker = Hawker::where("userID", "=", $userID)->get();
        return response()->json(["hawker" => $hawker]);
    }

    public function submitApplication(Request $request)
    {
        $hawkerID = $request->input("hawkerID");
        $status = ApplicationController::newApplication($request, $hawkerID);
        if ($status == "Application Submitted") {
            return response()->json(["status" => "success", "message" => $status]);
        } else {
            return response()->json(["status" => "error", "message" => $status]);
        }
    }

    public function trackApplications(Request $request)
    {
        $hawkerID = $request->hawkerID;
        $applications = ApplicationController::getApplications($hawkerID);
        return response()->json(["applications" => $applications]);
    }


    public function checkForLicense(Request $request)
    {
        $hawkerID = $request->hawkerID;
        $license = LicenseController::getLicense($hawkerID);
        if ($license)
            return response()->json(["status" => "success", "message" => "License Found", "license" => $license, "hawkerID" => $hawkerID]);
        else
            return response()->json(["status" => "error", "message" => "No License Found"]);
    }
}
