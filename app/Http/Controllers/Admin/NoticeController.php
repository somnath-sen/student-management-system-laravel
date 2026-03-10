<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        // Fetch all notices, newest first
        $notices = Notice::with('author')->latest()->get();
        return view('admin.notices.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        Notice::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'user_id' => Auth::id(), // Records who posted it
        ]);

        return back()->with('success', 'Notice broadcasted successfully!');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice removed from the board.');
    }
}