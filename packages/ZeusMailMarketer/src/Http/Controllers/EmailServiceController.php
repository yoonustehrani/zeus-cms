<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\EmailServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailServiceController extends Controller
{
    protected function getType($type)
    {
        return EmailServiceType::whereName($type)->firstOrFail();
    }
    public function index($type)
    {
        return $this->getType($type);
    }
    public function create()
    {

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