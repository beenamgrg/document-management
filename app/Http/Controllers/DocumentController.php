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
use App\Jobs\ProcessCSV;



class DocumentController extends Controller
{
    //Document Create

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'document' => 'required|mimes:csv,txt|max:' . config('fileSize.max_file_size'),
            ]);

            //Validation is working but I couldn't figure out  why the session is not storing error messages
            if ($validator->fails())
            {
                echo ($validator->errors()->all());
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()
                    ->withInput($request->input());
            }

            // Generate a unique identifier for the file
            $guid = Str::uuid();

            // Get the original name of the uploaded document
            $document_original_name = $request->document->getClientOriginalName();
            $document_name = pathinfo($document_original_name, PATHINFO_FILENAME);
            $document_size = $request->file('document')->getSize();

            // Move the uploaded file to the desired location
            $file_path = '/documents/';
            $file_name = $guid . '.' . $request->document->getClientOriginalExtension();
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
            $document->document_type = $request->document_type;
            $document->document_guid = $guid;
            $document->document_checksum = $checksum;
            $document->document_size = $document_size . ' bytes';
            $document->user_id = Auth::user()->id;
            $document->save();

            DB::commit();

            //Dispatch the job to generate json file of that csv file
            ProcessCSV::dispatch($file_path . $file_name, $guid);

            return redirect()->back()->with('success', 'Document uploaded successfully');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            Session::flash('error', 'Document could not be uploaded!!');
            return redirect()->back()->withInput($request->input());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try
        {
            //Authentication of the user
            $check = Document::where('user_id', Auth::user()->id)->where('document_guid', $request->id)->first();
            if ($check == NULL)
            {
                return redirect()->back()->with('error', 'Forbidden Access');
            }
            $check->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Document has been deleted successfully!!');
        }
        catch (Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        try
        {
            $file_path = public_path($request->file_name);

            // Check if the file exists
            if (file_exists($file_path))
            {
                // Return the file as a response for download
                return response()->download($file_path);
            }
            return redirect()->back()->with('error', 'File couldnot be downloaded');
        }
        catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
