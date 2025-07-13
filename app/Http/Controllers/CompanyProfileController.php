<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view company profile'])->only('index');
        // Jika ada edit, tambahkan:
        // $this->middleware(['permission:edit company profile'])->only('edit', 'update');
    }
    
    public function index()
    {
        // Anda bisa mengambil data dari database jika ada tabel company_profile
        // $companyProfile = \App\Models\CompanyProfile::first();
        return view('company_profile.index'); // , compact('companyProfile')
    }

    // Jika ingin ada fitur edit, Anda bisa tambahkan method edit dan update
}