<?php

namespace App\Http\Controllers;

use App\Models\Hawker;
use Illuminate\Http\Request;

use App\Http\Controllers\DocumentController;
use App\Models\Application;

use Exception;

class ApplicationController extends Controller
{
    // Hawker Functions
    public static function newApplication($request, $hawkerID)
    {
        $documents = $request->file("documents");
        $docsTypes = $request->input("types");
        $hawker = Hawker::find($hawkerID);
        try {
            $application = Application::create([
                "hawkerID" => $hawkerID,
                "address" => $hawker->address,
                "status" => "Pending"
            ]);
            if ($application) {
                for ($i = 0; $i < count($documents); $i++) {
                    $status = DocumentController::newDocument(
                        $application->applicationID,
                        $documents[$i],
                        $docsTypes[$i]
                    );
                    if (!$status) {
                        Application::destroy($application->applicationID);
                        return "Failed To Upload The File";
                    }
                }
                $status = PaymentController::makePayment($request, $application->applicationID);
                if (!$status) {
                    Application::destroy($application->applicationID);
                    return $status;
                } else {
                    return "Application Submitted";
                    // return "Application Submitted";
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getApplications($hawkerID)
    {
        $application = Application::where("hawkerID", "=", $hawkerID)->get();
        if ($application->isEmpty())
            return null;
        return $application;
    }

    // Verfication Officer Functions
    public static function getPendingApplications()
    {
        $applications = Application::where("status", "=", "Pending")->orWhere("status", "=", "Under Reviewing")->get();
        if ($applications->isEmpty())
            return null;
        return $applications;
    }

    public static function setApplicationStatus($applicationID, $status)
    {
        $application = Application::find($applicationID);
        $application->status = $status;
        $application->save();
    }

    // Ispection Officer Functions
    public static function getVerifiedApplications()
    {
        $application = Application::where("status", "=", "Waiting For Inspection")->orWhere('status', 'like', 'Inspection is set on%')->get();
        return $application ? $application : "No Verified Application";
    }

    // Admin Functions
    public static function getWaitingApprovalApplications()
    {
        $applications = Application::where("status", "=", "Waiting For Approval")->get();
        return $applications ? $applications : "No Waiting For Approval Applications";
    }
}
