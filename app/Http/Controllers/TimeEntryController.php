<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    public function index()
    {
        $entries = \App\Models\TimeEntry::where('user_id', auth()->id())->latest()->get();

        $todayEntries = $entries->filter(function ($entry) {
            return $entry->start_time->isToday();
        });

        $totalSeconds = $todayEntries->sum('duration');
        // Calculate dynamic accumulation for active timer if any?
        // For simple display, just sum stored durations. Active timer adds 0 until stopped in this logic,
        // but UI can simulate ticking.

        $totalHours = number_format($totalSeconds / 3600, 2);

        $activeTimer = \App\Models\TimeEntry::where('user_id', auth()->id())->whereNull('end_time')->first();

        return view('pages.productivity.index', compact('entries', 'totalHours', 'activeTimer', 'todayEntries'));
    }

    public function store(Request $request)
    {
        // Stop any running timer first
        $running = \App\Models\TimeEntry::where('user_id', auth()->id())->whereNull('end_time')->first();
        if ($running) {
            $running->update([
                'end_time' => now(),
                'duration' => now()->diffInSeconds($running->start_time)
            ]);
        }

        \App\Models\TimeEntry::create([
            'user_id' => auth()->id(),
            'task_id' => $request->task_id,
            'description' => $request->description,
            'start_time' => now(),
        ]);

        return back()->with('success', 'Timer started');
    }

    public function update(Request $request, \App\Models\TimeEntry $timeEntry)
    {
        if ($timeEntry->user_id !== auth()->id()) {
            abort(403);
        }

        $timeEntry->update([
            'end_time' => now(),
            'duration' => now()->diffInSeconds($timeEntry->start_time)
        ]);

        return back()->with('success', 'Timer stopped');
    }
}
