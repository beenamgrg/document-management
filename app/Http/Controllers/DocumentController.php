<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Document;



class DocumentController extends Controller
{
    //Document Create
    public function create()
    {
        return view('document.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $validator = Validator::make($request->all(), [
                'document' => 'required|mimes:csv|max:' . config('fileSize.max_file_size'),
            ]);
            if ($validator->fails())
            {
                Session::flash('warning', 'Validation Error');
                return redirect()->back()->withInput($request->input());
            }
            // Generate a unique identifier for the file
            $guid = Str::uuid();

            // Get the original name of the uploaded document
            $document_original_name = $request->document->getClientOriginalName();
            $document_name = pathinfo($document_original_name, PATHINFO_FILENAME);
            $type = pathinfo($document_original_name, PATHINFO_EXTENSION);
            $document_size = $request->file('document')->getSize();

            // Move the uploaded file to the desired location
            $file_path = '/documents/';
            $file_name = $guid . '.' . $request->document->extension();
            $request->file('document')->move(public_path($file_path), $file_name);

            // Construct the full path to the uploaded file
            $file_path_with_name = public_path($file_path . $file_name);

            // Check if the file exists
            if (!file_exists($file_path_with_name))
            {
                throw new \Exception('File does not exist: ' . $file_path_with_name);
            }

            // Calculate the checksum of the uploaded document
            $checksum = md5_file($file_path_with_name);

            $document = new Document();
            $document->document_name = $document_name;
            $document->document_file = $file_path . $file_name; // Corrected file path
            // $document->document_type = $type;
            $document->document_guid = $guid;
            $document->document_checksum = $checksum;
            $document->document_size = $document_size . ' bytes';
            $document->user_id = Auth::user()->id;
            $document->save();

            DB::commit();

            return redirect()->back()->with('success', 'Document created successfully');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            Session::flash('error', 'couldnot create');
            return redirect()->back()->withInput($request->input());
        }
    }
}
