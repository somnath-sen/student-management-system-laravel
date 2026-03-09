<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApplicantController extends Controller
{
    // Replace this with your newly deployed Google Apps Script URL
    private $scriptUrl = 'https://script.google.com/macros/s/AKfycbzpQCXsq41oM7ml2NJWkLcfKjXn7KoVbUZLFz_VD8zG8BKqxOYh-NFPWP1ED2ePqbxV/exec';

    public function students()
    {
        // Fetch data from Google Sheets API
        $response = Http::get($this->scriptUrl . '?type=Students');
        $applicants = $response->successful() ? $response->json() : [];
        
        // Reverse the array so the newest applications show up first
        $applicants = array_reverse($applicants);

        return view('admin.applicants.students', compact('applicants'));
    }

    public function teachers()
    {
        // Fetch data from Google Sheets API
        $response = Http::get($this->scriptUrl . '?type=Teachers');
        $applicants = $response->successful() ? $response->json() : [];
        
        $applicants = array_reverse($applicants);

        return view('admin.applicants.teachers', compact('applicants'));
    }
}