<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('contacts.import');
    }


    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml'
        ]);
        $xml = simplexml_load_file($request->file('xml_file'));
        $nameFormatter = App::make('nameFormatter');

        $skipped = [];

        foreach ($xml->contact as $contact) {
            $phone = (string) $contact->phone;
            if (Contact::where('phone', $phone)->exists()) {
                $skipped[] = $phone;
                continue;
            }
            Contact::create([
                'name' => $nameFormatter->format((string) $contact->name),
                'phone' => $phone,
            ]);
        }
    
        $message = Lang::get('message.alerts.contact_import');
        if (!empty($skipped)) {
            $message .= ' ' . count($skipped) . ' duplicate(s) skipped.';
        }
    
        return redirect()->route('contacts.index')
            ->with('status', $message);
    }
}
