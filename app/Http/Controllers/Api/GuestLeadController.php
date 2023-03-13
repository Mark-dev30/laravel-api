<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Models\GuestLead;
use App\Mail\GuestContact;

class GuestLeadController extends Controller
{
    public function store(Request $request)
    {
        $form = $request->all();

        $validator = Validator::make($form, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'text' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $newContact = new GuestLead();
        $newContact->fill($form);
        $newContact->save();

        Mail::to('info@portfolio.com')->send(new GuestContact($newContact));

        return response()->json([
            'success' => true
        ]);
    }
}
