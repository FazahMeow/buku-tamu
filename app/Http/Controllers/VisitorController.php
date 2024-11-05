<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\FormData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index()
    {
        // Mengambil semua data visitor
        $visitors = FormData::all();

        // Mengirim data pengunjung ke view dashboard
        return view('login-page.pengunjung', compact('visitors'));
    }

    public function dashboard(Request $request)
    {
        $timeRange = $request->input('time_range', 'monthly');
        $visitors = $this->getVisitors($timeRange);

        if ($request->ajax()) {
            return response()->json($visitors);
        }

        $visitorTableData = FormData::select('nama', 'email', 'dibuat_pada')
            ->whereMonth('dibuat_pada', Carbon::now()->month)
            ->whereYear('dibuat_pada', Carbon::now()->year)
            ->orderBy('dibuat_pada', 'desc')
            ->get();

        // Hitung total pengunjung per bulan
        $totalVisitorsPerMonth = $this->getMonthlyVisitors();

        return view('login-page.dashboard', compact('visitors', 'visitorTableData', 'timeRange', 'totalVisitorsPerMonth'));
    }

    private function getVisitors($timeRange)
    {
        switch ($timeRange) {
            case 'yearly':
                return $this->getYearlyVisitors();
            case 'monthly':
            default:
                return $this->getMonthlyVisitors();
        }
    }

    private function getMonthlyVisitors()
    {
        return FormData::select(DB::raw('YEAR(dibuat_pada) as year'), DB::raw('MONTH(dibuat_pada) as month'), DB::raw('COUNT(*) as count'))
            ->whereBetween('dibuat_pada', [Carbon::now()->subMonths(12), Carbon::now()])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1)->format('Y-m');
                return [$date => $item->count];
            })
            ->toArray();
    }

    private function getYearlyVisitors()
    {
        return FormData::select(DB::raw('YEAR(dibuat_pada) as year'), DB::raw('COUNT(*) as count'))
            ->whereBetween('dibuat_pada', [Carbon::now()->subYears(5), Carbon::now()])
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->pluck('count', 'year')
            ->toArray();
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'company' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Menyimpan data visitor ke database
        $visitor = new Visitor();
        $visitor->name = $request->name;
        $visitor->phone = $request->phone;
        $visitor->email = $request->email;
        $visitor->company = $request->company;
        $visitor->purpose = $request->purpose;
        $visitor->remarks = $request->remarks;
        $visitor->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data visitor berhasil disimpan.');
    }
}