<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display users and stores management
     */
    public function index()
    {
        $users = User::with('store')->latest()->paginate(20);
        $stores = Store::with('user')->latest()->paginate(20);
        
        // Stats
        $totalUsers = User::count();
        $totalStores = Store::count();
        $verifiedStores = Store::where('is_verified', true)->count();
        $pendingStores = Store::where('is_verified', false)->count();
        
        return view('admin.users.index', compact('users', 'stores', 'totalUsers', 'totalStores', 'verifiedStores', 'pendingStores'));
    }
    
    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users!');
        }
        
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
    
    /**
     * Delete a store
     */
    public function deleteStore(Store $store)
    {
        $store->delete();
        return back()->with('success', 'Store deleted successfully!');
    }
}
