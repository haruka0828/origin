<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
{
    $companies = Company::all();
    return view('companies.index', compact('companies'));
}
}
