<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Hawker;
use App\Models\InspectionOfficer;
use App\Models\VerficationOfficer;

use Exception;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $firstName = $request->input("firstName");
        $lastName = $request->input("lastName");
        $email = $request->input("email");
        $password = $request->input("password");
        $role = $request->input("role");

        try {
            $user = User::create([
                "firstName" => $firstName,
                "lastName" => $lastName,
                "email" => $email,
                "password" => Hash::make($password),
                "role" => $role
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }

        if ($user && $role == "Hawker") {
            try {
                $hawker = Hawker::create([
                    "userID" => $user->userID,
                    "nric" => $request->input("nric"),
                    "address" => $request->input("address")
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => "Account Created Successfully",
                    "hawkerID" => $hawker->hawkerID,
                    "userInfo" => $user
                ]);
            } catch (Exception $e) {
                $user->delete();
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }

        } else if ($user && $role == "Inspection Officer") {
            try {
                $inspectionOfficer = InspectionOfficer::create([
                    "userID" => $user->userID
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => "Account Created Successfully",
                    "inspectionOfficerID" => $inspectionOfficer->inspectionOfficerID,
                    "userInfo" => $user
                ]);
            } catch (Exception $e) {
                $user->delete();
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else if ($user && $role == "Verification Officer") {
            try {
                $verficationOfficer = VerficationOfficer::create([
                    "userID" => $user->userID
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => "Account Created Successfully",
                    "verficationOfficerID" => $verficationOfficer->verficationOfficerID,
                    "userInfo" => $user
                ]);
            } catch (Exception $e) {
                $user->delete();
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }

        }
    }
    //
    public function login(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        // $hashedPass = Hash::make($password);
        // return $hashedPass;
        $user = User::where("email", $email)->first();
        //
        if ($user && Hash::check($password, $user->password)) {
            // return ($email . $password);
            return response()->json([
                "status" => "success",
                "message" => "Loggedin Successfully",
                "userInfo" => $user
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Email or Password is Worng"
            ]);
        }
    }

    public function restPassword(Request $request)
    {
        $userID = $request->input("email");
        $password = $request->input("password");

        $user = User::where("email", $userID)->first();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            return response()->json([
                "status" => "success",
                "message" => "Password Updated Successfully"
            ]);
        } else
            return response()->json([
                "status" => "error",
                "message" => "User Not Found"
            ]);
    }

    public static function getAllUsers()
    {
        $users = User::where("role", "=", "Verification Officer")->orWhere("role", "=", "Inspection Officer")->get();
        return $users;
    }

    public static function removeUser($userID)
    {
        $user = User::find($userID);
        $status = $user->delete();
        return $status;
    }
}
