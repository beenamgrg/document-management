<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::select('documents.*', 'users.name as uploaded_by')
            ->leftjoin('users', 'users.id', 'documents.user_id')
            ->orderBy('documents.created_at', 'DESC')
            ->paginate(5);
        $document_count = (Auth::user()->role == 'admin') ? Document::count() : Document::where('user_id', Auth::user()->id)->count();
        // dd($documents->links());
        return view('dashboard.index', compact('document_count', 'documents'));
    }
}
