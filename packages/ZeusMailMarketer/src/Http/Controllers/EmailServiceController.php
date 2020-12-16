<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\EmailService;
use App\EmailServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailServiceController extends Controller
{
    protected function getType($type)
    {
        return EmailServiceType::whereName($type)->firstOrFail();
    }
    public function index()
    {
        $email_services = EmailService::with('type')->get();
        return view('ZEMMV::pages.email_services.index', compact('email_services'));
    }
    public function create()
    {
        $types = EmailServiceType::all();
        return $types;
    }
    public function store(Request $request)
    {
        
    }
    public function show($email_service)
    {
        
    }
    public function edit($email_service)
    {

    }
    public function update(Request $request, $email_service)
    {

    }
    public function delete($email_service)
    {

    }
}