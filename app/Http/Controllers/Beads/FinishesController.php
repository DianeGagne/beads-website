<?php

namespace App\Http\Controllers\Beads;

use App\userFavorites;

use App\Beads;
use App\Finishes;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FinishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified bead.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $bead = Beads::findOrFail($id);

        //update the image to contain the full link
        $finish = $bead->finishes->lists('name');

        $userFavorites = Auth::user()->userFavorites;

        $data['bead'] = $bead;
        $data['userFavorites'] = $userFavorites;

        return view('beads.single_bead')->with($data);
    }


    /**
     * Show the specification for all the beads in the db
     * @return $this
     */
    public function getFinishes()
    {
        $finishes = Finishes::all();

        $data['finishes'] = Finishes::all();

        return view('beads.beads')->with($data);
    }

    /**
     * Get an array of all the beads for the pattern maker
     * @return array
     */
    public function allFinishesSelect()
    {
        $finishes = Finishes::all();

        $finishesArray = ($finishes->map(function($input){
            return ['label' => $input->name, 'value' => $input->id];
        }))->toArray();

        return json_encode($finishesArray);
    }



}
