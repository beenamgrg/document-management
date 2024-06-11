<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $paginate = env('PAGINATION') ?? 5;
        $document_count = Document::count();
        $users = User::select('users.*', \DB::raw('COUNT(documents.id) as document_count'))
            ->leftjoin('documents', 'users.id', 'documents.user_id')
            ->where('users.id', '!=', Auth::user()->id)
            ->groupBy('users.id', 'users.name')
            ->paginate($paginate);
        return view('users.index', compact('document_count', 'users'));
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try
        {
            // dd($request->all());
            User::where('id', $request->id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'User deleted successfully');
        }
        catch (Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }
}
