<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class EnrollController extends Controller
{
    public function enroll(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'usr_full_name' => 'required|string|max:255',
            'usr_sex' => 'required|string|in:Male,Female',
            'usr_address' => 'required|string|max:255',
            'usr_birth_date' => 'required|date',
            'usr_mobile' => 'required|string|max:15',
            'usr_email' => 'required|email|max:255',
        ]);

        // Check if the user exists in the 'users' table
        $user = DB::table('users')
            ->where('usr_email', '=', $validatedData['usr_email'])
            ->first();

        if ($user) {
            // Use the existing usr_id from the 'users' table
            $usr_id = $user->usr_id;

            // Update the existing record in 'users_personal_information'
            DB::table('users_personal_information')
                ->updateOrInsert(
                    ['usr_id' => $usr_id], // Match by usr_id
                    [
                        'usr_full_name' => $validatedData['usr_full_name'],
                        'usr_sex' => $validatedData['usr_sex'],
                        'usr_address' => $validatedData['usr_address'],
                        'usr_birth_date' => $validatedData['usr_birth_date'],
                        'usr_mobile' => $validatedData['usr_mobile'],
                        'usr_email' => $validatedData['usr_email'],
                    ]
                );

            // Update usr_birth_date and usr_mobile in the 'users' table
            DB::table('users')
                ->where('usr_id', $usr_id)
                ->update([
                    'usr_birth_date' => $validatedData['usr_birth_date'],
                    'usr_mobile' => $validatedData['usr_mobile'],
                ]);
        } else {
            // Handle the case where the user is not registered yet
            alert()->error('User not registered', 'No user with the email ' . $validatedData['usr_email'] . ' found.');
            return redirect()->back();
        }

        // Redirect to home
        return redirect()->action([AdminController::class, 'home']);
    }
}
