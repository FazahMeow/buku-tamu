<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        // Mengambil semua data visitor
        $visitors = Visitor::all();

        // Mengirim data visitors ke view dashboard
        return view('login-page.dashboard', compact('visitors'));
    }

    public function report()
    {
        // Ambil data pengunjung hari ini
        $todayVisitors = Visitor::whereDate('created_at', Carbon::today())->count();

        // Ambil total pengunjung per bulan
        $monthlyVisitors = Visitor::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Lengkapi data pengunjung per bulan (0 jika tidak ada data)
        $totalVisitorsPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalVisitorsPerMonth[$i] = $monthlyVisitors[$i] ?? 0;
        }

        // Ambil nama, email, dan waktu masuk untuk tabel
        $visitorTableData = Visitor::select('name', 'email', 'created_at')->get();

        // Mengirim data ke view report
        return view('login-page.report', compact('totalVisitorsPerMonth', 'todayVisitors', 'visitorTableData'));
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
