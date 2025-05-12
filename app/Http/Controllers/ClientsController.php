<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Http\Requests\StoreclientsRequest;
use App\Http\Requests\UpdateclientsRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Client::addSelect(['id','name'])->orderByDesc('id')->get();
        return View('clients.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('clients.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreclientsRequest $request) : RedirectResponse
    {
        $client = Client::create($request->all());

        return redirect('/clients')->with('success', 'client ajouté');

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $clients, $id)
    {
        $client = Client::find($id);

        return View('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateclientsRequest $request,string $id)
    {
        $client = Client::find($id); 

        if($client->update($request->all())){
            return redirect()->route('client.index')->with('success', 'Modifier');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $clients, $id)
    {
        Client::destroy($id);
        return redirect()->route('client.index')->with('success', 'Supprimer');
    }
}
