<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;

class AdminController extends Controller
{
    //
    public function viewUsers(Request $request)
    {
        $users  = UserController::getAllUsers();
        return response()->json($users);
    }

    public function addNewUser(Request $request)
    {
        $user = new UserController();
        $user->register($request);
    }

    public function removeUser()
    {
        $userID = request()->input("userID");
        $deletionStatus = UserController::removeUser($userID);
        return response()->json(["deletionStatus"=>$deletionStatus]);
    }

    public function viewApplications(Request $request)
    {
        $applications = ApplicationController::getWaitingApprovalApplications();
        return response()->json(["applications"=>$applications]);
    }

    public function getInspectionReport(Request $request)
    {
        $applicatioID = $request->applicationID;
        $reportPath = InspectionController::getInspectionReport( $applicatioID );
        $path = $reportPath->inspectionReportPath;
        if(Storage::disk('public')->exists($path))
        {
            return Storage::disk('public')->download($path);
        }
    }

    public function issueLicesnse()
    {
        $applicationID = request()->input("applicatiionID");
        $hawkerID = request()->input("hawkerID");

        ApplicationController::setApplicationStatus($applicationID, "Approved");
        $license = LicenseController::issueLicense($hawkerID);
        return response()->json(["license"=>$license]);
    }

    public function rejectApplication(Request $request)
    {
        $applicationID = request()->input("applicationID");
        ApplicationController::setApplicationStatus($applicationID, "Rejected");
        return response()->json(["status"=>"success"]);
    }
}
