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
        return EmailServiceType::whereId($type)->firstOrFail();
    }
    public function index()
    {
        $email_services = EmailService::with('type')->get();
        return view('ZEMMV::pages.email_services.index', compact('email_services'));
    }
    public function create()
    {
        $types = EmailServiceType::all();
        return view('ZEMMV::pages.email_services.create', compact('types'));
    }
    public function store(Request $request)
    {
        $type = $this->getType($request->type);
        $service = new EmailService;
        $service->name = $request->name;
        $service->details = $request->settings;
        $type->services()->create($service->toArray());
        return redirect()->to(route(config('ZECMM.controllers.route') . 'services.index'));
    }
    public function show($email_service)
    {
        return EmailService::with('type')->whereId($email_service)->firstOrFail();
    }
    public function edit($email_service)
    {
        $service = EmailService::whereId($email_service)->firstOrFail();
        $types = EmailServiceType::all();
        return view('ZEMMV::pages.email_services.edit', compact('service', 'types'));
    }
    public function update(Request $request, $email_service)
    {
        $service = EmailService::whereId($email_service)->firstOrFail();
        $service->name = $request->name;
        $service->details = encrypt(json_encode(json_decode($request->settings)));
        $service->type_id = optional($this->getType($request->type))->id;
        $service->save();
        return back();
    }
    public function delete($email_service)
    {
        $email_service = EmailService::whereId($email_service)->firstOrFail();
        $email_service->delete();
    }
}