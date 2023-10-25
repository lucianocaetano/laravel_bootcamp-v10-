<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with("user")->latest()->get();
        return view("chirps.index", [
            "chirps" => $chirps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "message" => ["required", "min:3"]
        ]);

        $message = $request->get("message");
        auth()->user()->chirps()->create($validate);
        //session()->flash(); //flash hace que el mensaje desaparesca en la sigiente peticion
        return to_route("chirps.index")
            ->with("status", __("Chirp Created Successfully!"));// es lo mismo que flash        
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize("update", $chirp); 
        return view("chirps.edit", [
            "chirp" => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize("update", $chirp);
        $validate = $request->validate([
            "message" => ["required", "min:3", "max:255"]
        ]);

        $chirp->update($validate);

        return to_route("chirps.index")->with("status", __("Chirp updated successfully!"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize("delete", $chirp);

        $chirp->delete();

        return to_route("chirps.index")->with("status", __("Chirp deleted successfully"));
    }
}
