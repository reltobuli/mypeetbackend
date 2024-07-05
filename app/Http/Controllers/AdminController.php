<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;use App\Models\Shelter; 
use App\Models\VeterinaryCenter; // Correctly import the model



class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function instructions()
    {
        return view('admin.instructions');
    }


    public function shelters()
{
    $shelters = Shelter::all();
    return view('admin.shelters.shelters', compact('shelters'));
}
public function profile()
    {
        return view('admin.profile');
    }
public function veterinary()
{
    $veterinaryCenters = VeterinaryCenter::all();
    return view('admin.veterinary', compact('veterinaryCenters'));
}
public function updateProfile(Request $request)
{
    $user = Auth::user();
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8|confirmed',
    ]);

    $user->email = $request->input('email');
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }
    $user->save();

    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
}
public function storeVeterinaryCenter(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'city' => 'required|string|max:255',
    ]);

    VeterinaryCenter::create($request->all());

    return redirect()->route('admin.veterinary')->with('success', 'Veterinary Center created successfully');
}

public function editVeterinaryCenter($id)
{
    $veterinaryCenter = VeterinaryCenter::findOrFail($id);
    $veterinaryCenters = VeterinaryCenter::all();
    return view('admin.veterinary', compact('veterinaryCenter', 'veterinaryCenters'));
}

public function updateVeterinaryCenter(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'city' => 'required|string|max:255',
    ]);

    $veterinaryCenter = VeterinaryCenter::findOrFail($id);
    $veterinaryCenter->update($request->all());

    return redirect()->route('admin.veterinary')->with('success', 'Veterinary Center updated successfully');
}

public function deleteVeterinaryCenter($id)
{
    $veterinaryCenter = VeterinaryCenter::findOrFail($id);
    $veterinaryCenter->delete();

    return redirect()->route('admin.veterinary')->with('success', 'Veterinary Center deleted successfully');
}




   public function storeShelter(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'capacity' => 'required|integer',
        'city' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    Shelter::create($request->all());

    return redirect()->route('admin.shelters')->with('success', 'Shelter created successfully');
}


public function editShelter($id)
{
    $shelter = Shelter::findOrFail($id);
    return view('admin.edit_shelter', compact('shelter'));
}

public function updateShelter(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'capacity' => 'required|integer',
        'city' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    $shelter = Shelter::findOrFail($id);
    $shelter->update($request->all());

    return redirect()->route('admin.shelters')->with('success', 'Shelter updated successfully');
}

public function deleteShelter($id)
{
    $shelter = Shelter::findOrFail($id);
    $shelter->delete();

    return redirect()->route('admin.shelters')->with('success', 'Shelter deleted successfully');
}

}
