<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user memiliki resident
        if (!$user->resident) {
            return redirect()->route('home')->with('error', 'Data resident tidak ditemukan');
        }

        $residentId = $user->resident->id;

        // Ambil semua laporan user dengan status terbaru
        $reports = Report::where('resident_id', $residentId)
            ->with(['reportStatuses' => function ($query) {
                $query->latest();
            }])
            ->get();

        // Hitung laporan aktif
        $activeReports = $reports->filter(function ($report) {
            $latestStatus = $report->reportStatuses->first();
            return $latestStatus && in_array($latestStatus->status, ['pending', 'in_progress', 'on_process']);
        })->count();

        // Hitung laporan selesai
        $completedReports = $reports->filter(function ($report) {
            $latestStatus = $report->reportStatuses->first();
            return $latestStatus && $latestStatus->status === 'resolved';
        })->count();

        return view('pages.app.profile', compact('activeReports', 'completedReports'));
    }
}
