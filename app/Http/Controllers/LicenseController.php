<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    //
    public static function issueLicense($hawkerID)
    {
        $issueDate = now()->format("Y - m - d");
        $expirationDate = now()->addYear()->format("Y - m - d");
        $license = License::create([
            "hawkerID"=> $hawkerID,
            "issueDate"=> $issueDate,
            "expirationDate"=> $expirationDate,
            "status"=> "Valid"
        ]);

        return $license;
    }

    public static function getLicense($hawkerID)
    {
        $license = License::where("hawkerID", "=", $hawkerID)->get();
        if ($license->isEmpty())
            return null;
        else
            return $license;
    }
}
