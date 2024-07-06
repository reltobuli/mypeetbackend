<?php

// app/Http/Controllers/VeterinaryController.php

// app/Http/Controllers/VeterinaryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VeterinaryCenter;

class VeterinaryController extends Controller
{
    public function index()
    {
        $veterinaryCenter = VeterinaryCenter::all();
        return response()->json($veterinaryCenter);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        Veterinary::create([
            'name' => $request->name,
            'location' => $request->location,
            'rating' => $request->rating,
        ]);

        return redirect()->route('admin.veterinary')->with('success', 'Veterinary center created successfully');
    }

    public function edit($id)
    {
        $veterinaryCenter = VeterinaryCenter::findOrFail($id);
        return view('admin.edit_veterinary', compact('veterinaryCenter'));
    }

    public function update(Request $request, $id)
    {
        $veterinaryCenter = VeterinaryCenter::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $veterinaryCenter->update([
            'name' => $request->name,
            'location' => $request->location,
            'rating' => $request->rating,
        ]);

        return redirect()->route('admin.veterinary')->with('success', 'Veterinary center updated successfully');
    }

    public function destroy($id)
    {
        $veterinaryCenter = VeterinaryCenter::findOrFail($id);
        $veterinaryCenter->delete();

        return redirect()->route('admin.veterinary')->with('success', 'Veterinary center deleted successfully');
    }
}
