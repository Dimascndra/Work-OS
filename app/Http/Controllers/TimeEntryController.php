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

        // Aggregated Stats
        $stats = [
            'tasks_count' => \App\Models\Task::count(),
            'tasks_completed' => \App\Models\Task::where('status', 'completed')->count(), // Assuming status column exists
            'snippets_count' => \App\Models\Snippet::count(),
            'short_urls_count' => \App\Models\ShortUrl::count(),
            'short_urls_clicks' => \App\Models\ShortUrl::sum('clicks'),
        ];

        return view('pages.productivity.index', compact('entries', 'totalHours', 'activeTimer', 'todayEntries', 'stats'));
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
