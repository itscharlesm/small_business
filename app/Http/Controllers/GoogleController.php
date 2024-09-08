<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * redirect
     * 
     * @param String provider 
     */
    public function redirect($provider)
    {
        // Initialize provider(google) login
        return Socialite::driver($provider)->redirect();
    }

    /**
     * callback
     * 
     * @param String provider
     */
    public function callback($provider)
    {
        // Fetch google user
        $google_user =  Socialite::driver($provider)->user();

        // Check if google user's email exists on the database
        $user = User::whereUsrEmail($google_user->email)->whereUsrActive(1)->first();

        if (!$user) {
            // If user's email does not exist, create a new User instance
            $uuid = generateuuid();
            $google_profile_photo = $google_user->avatar;

            // Check if google user's profile photo exists and store it 
            if ($google_profile_photo) {
                $file_name = 'images/user/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($file_name, file_get_contents($google_profile_photo));
            }

            // Create new User instance
            $user = User::create([
                'usr_uuid' => $uuid,
                'typ_id' => 1,
                'usr_email' => $google_user->email,
                // Temporary value sa password kay UUID
                'usr_password' => md5($uuid),
                'usr_last_name' => $google_user->user->familyName,
                'usr_first_name' => $google_user->user->givenName,
                'usr_image_path' => $file_name ?? null,
                'usr_is_verified' => 1,
                'usr_date_verified' => Carbon::now()
            ]);
        }
        // Referenced to [LoginController::class,'login']
        resetUserLoginCounter($user->usr_email);
        setUserSessionVariables($user);
        return redirect()->action([AdminController::class, 'home']);
    }
}
