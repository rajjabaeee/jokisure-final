<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'user_name',
        'user_nametag',
        'user_password_hash',
        'user_number',
        'user_profile_pic',
        'user_email',
        'created_at'
    ];

    protected $hidden = [
        'user_password_hash',
        'remember_token' // optional: add column if you create it
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Return the password value for the auth system (non-standard column).
     */
    public function getAuthPassword()
    {
        return $this->user_password_hash;
    }

    /**
     * Get the buyer profile associated with this user
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'user_id', 'user_id');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
        ]);

        $identity = $request->input('identity');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // jika identity email -> coba kolom user_email
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['user_email' => $identity, 'password' => $password];
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return redirect()->intended(route('home'));
            }
        } else {
            // bukan email -> coba user_name dan user_nametag
            $tries = [
                ['user_name' => $identity, 'password' => $password],
                ['user_nametag' => $identity, 'password' => $password],
            ];

            foreach ($tries as $credentials) {
                if (Auth::attempt($credentials, $remember)) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('home'));
                }
            }
        }

        return back()
            ->withErrors(['identity' => 'Credentials do not match our records.'])
            ->withInput($request->only('identity'));
    }
}
