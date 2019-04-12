<?php

use Illuminate\Http\Request;
use App\Contact;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by thephphp RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function() {
    // Fetch Contacts
    Route::get('contacts', function() {
        return Contact::latest()->OrderBy('created_at','desc')->get();
    });

    // Get Single Contact
    Route::get('contact/{id}',function($id) {
        return Contact::findOrFail($id);
    });

    // Add Contact 
    Route::post('contact/store',function(Request $request) {
        return Contact::create([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone'])
            ]);
    });

    // Update Contact
    Route::patch('contact/{id}',function(Request $request,$id) {
        Contact::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone'])
            ]);
    });

    // Delete Contact
    Route::delete('contact/delete/{id}',function($id) {
        Contact::destroy($id);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
