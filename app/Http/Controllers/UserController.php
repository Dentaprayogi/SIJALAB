<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('web.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('web.user.show', compact('user'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Cegah user dengan role teknisi diubah statusnya
        if ($user->role === 'teknisi') {
            return response()->json(['message' => 'User teknisi tidak boleh diubah statusnya.'], 403);
        }
    
        $status = $request->status_user;
        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return response()->json(['message' => 'Status tidak valid.'], 422);
        }
    
        $user->status_user = $status;
        $user->save();
    
        return response()->json(['message' => 'Status user berhasil diubah']);
    }    

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'teknisi') {
            return redirect()->back()->with('error', 'User dengan role teknisi tidak boleh dihapus.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

}
