<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

use Exception;

class DocumentController extends Controller
{
    //
    public static function newDocument ($applicatioID, $document, $documentType)
    {
        try
        {
            $documentName = $document->getClientOriginalName(); // original file name as uploaded from the user
            $date = now()->format("Y-m-d");
            $newDocumentName = $date . "-" . $documentName; // file name as the system naming convention

            $filePath = $document->storeAs("uploads/documents", $newDocumentName, 'public');

            Document::create([
                "applicationID"=> $applicatioID,
                "documentType"=> $documentType,
                "documentName"=> $documentName,
                "path"=> $filePath
            ]);

            return $filePath;
        } catch (Exception $e)
        {
            return $e;
        }
    }

    public static function getDocumentsByApplicationID ($applicationID)
    {
        $documents = Document::where("applicationID", "=", $applicationID)->get();
        return $documents;
    }

    public function downloadDocument (Request $request)
    {
        $path = $request->path;
        // return $path;
        if(Storage::disk('public')->exists("/uploads/documents/".$path))
        {
            return Storage::disk('public')->download("/uploads/documents/".$path);
        }
        else
        {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
