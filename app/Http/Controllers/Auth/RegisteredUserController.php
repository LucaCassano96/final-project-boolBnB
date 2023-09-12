<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'nullable', 'max:255'],
            'surname' => [ 'string', 'nullable',  'max:255'],
            'date_of_birth' => ['date', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],

        [

            'name.string'=> "Il nome deve essere composto da caratteri",
            'name.max'=> "Il nome non può superare i 255 caratteri",

            'surname.string'=> "Il cognome deve essere composto da caratteri",
            'surname.max'=> "Il cognome non può superare i 255 caratteri",

            'date_of_birth.date'=> "la data deve avere il formato gg/mm/aaaa",


            'email.required'=> "È necessario inserire una email",
            'email.string'=> "L'email deve essere composta da caratteri",
            'email.email'=> "l'email deve avere il formato mail ad es: mario.rossi@gmail.com",
            'email.max'=> "l'email non può superare i 255 caratteri",
            'email.unique'=> "Questa mail è già stata usata",

            'password.required'=> "È necessario inserire una password",
            'password.confirmed'=> "La password deve essere confermata",
            'password.min'=> "La password deve contenere almeno 8 caratteri",

        ]
    );

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
