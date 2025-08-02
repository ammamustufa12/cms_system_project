<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
  public function index(Request $request)
{
    $query = ActivityLog::with('user')->latest();

    if ($request->has('search') && $request->search !== '') {
        $query->where('description', 'like', '%' . $request->search . '%')
              ->orWhere('action', 'like', '%' . $request->search . '%');
    }

    $logs = $query->paginate(20);

    return view('vendor.twill.activity_logs.list', compact('logs'));
}
    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', compact('activityLog'));
    }
}
