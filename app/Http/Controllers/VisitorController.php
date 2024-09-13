<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        // Mengambil semua data visitor
        $visitors = Visitor::all();

        // Mengirim data visitors ke view dashboard
        return view('login-page.dashboard', compact('visitors'));
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
