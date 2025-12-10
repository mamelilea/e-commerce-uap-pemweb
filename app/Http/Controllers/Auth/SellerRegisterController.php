<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class SellerRegisterController extends Controller
{
    /**
     * Display the seller registration view.
     */
    public function create(): View
    {
        return view('auth.seller-register');
    }

    /**
     * Handle an incoming seller registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // User data
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Store data
            'store_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'about' => ['required', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'postal_code' => ['required', 'string', 'max:10'],
        ]);

        DB::beginTransaction();

        try {
            // Create user with role 'seller'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'seller', // ← UBAH INI dari 'member' ke 'seller'
            ]);

            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('store-logos', 'public');
            }

            // Create store for the seller
            Store::create([
                'user_id' => $user->id,
                'name' => $request->store_name,
                'logo' => $logoPath,
                'about' => $request->about,
                'phone' => $request->phone,
                'address_id' => '',
                'city' => $request->city,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'is_verified' => false,
                'verified_by' => null,
                'verified_at' => null,
                'rejection_reason' => null,
            ]);

            DB::commit();

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Seller Registration Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            // Tampilkan error di development (hapus di production)
            if (config('app.debug')) {
                return back()->withInput()->withErrors([
                    'error' => 'Error: ' . $e->getMessage()
                ]);
            }

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
            ]);
        }
    }
}
