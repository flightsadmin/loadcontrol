<?php
namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    // List all email templates
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('email_templates.index', compact('templates'));
    }

    // Show the form to create a new template
    public function create()
    {
        return view('email_templates.create');
    }

    // Store a newly created email template in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('email_templates.index')->with('success', 'Email template created successfully.');
    }

    // Show the form to edit an existing template
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('email_templates.edit', compact('emailTemplate'));
    }

    // Update an existing email template in the database
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ]);

        $emailTemplate->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('email_templates.index')->with('success', 'Email template updated successfully.');
    }

    // Delete an email template
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect()->route('email_templates.index')->with('success', 'Email template deleted successfully.');
    }
}
