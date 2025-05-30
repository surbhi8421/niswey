<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => [
                'required',
                'regex:/^\+?[1-9]\d{1,14}$/',
            ]
        ]);

        $validated['name'] = App::make('nameFormatter')->format($validated['name']);
        Contact::create($validated);
        return redirect()->route('contacts.index')
        ->with('status',Lang::get('message.alerts.contact_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showContacts = Contact::findOrFail($id);
        return view('contacts.show',compact('showContacts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => [
                'required',
                'regex:/^\+?[1-9]\d{1,14}$/',
            ]
        ]);
    
        $validated['name'] = App::make('nameFormatter')->format($validated['name']);
        $contact = Contact::findOrFail($id);
        $contact->update($validated);
        return redirect()->route('contacts.index')
            ->with('status',Lang::get('message.alerts.contact_updated'));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index')
        ->with('status',Lang::get('message.alerts.contact_deleted'));
    }

    public function importXml(Request $request) {

        if ($request->file('xml_file')->getClientOriginalExtension() !== 'xml') {
            return back()->withErrors(['xml_file' => 'The file must be an XML file.']);
        }
        
        $xml = simplexml_load_file($request->file('xml_file')->getRealPath());

        $skipped = [];
        $imported = 0;

        foreach ($xml->contact as $contact) {
            $phone = (string) $contact->phone;
            if (Contact::where('phone', $phone)->exists()) {
                $skipped[] = $phone;
                continue;
            }
            Contact::create([
                'name' => (string) $contact->name,
                'phone' => $phone,
            ]);

            $imported++;
        }

        $message = "Contacts imported successfully.";
        if (!empty($skipped)) {
            $message .= ' ' . count($skipped) . ' duplicate(s) skipped.';
        }

        return redirect()->route('contacts.index')
            ->with('status', $message);
    }
}