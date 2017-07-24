<?php

namespace App\Http\Controllers\Beads;

use App\userFavorites;
use Illuminate\Http\Request;

use App\Beads;
use App\Finishes;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BeadsController extends Controller
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
    public function getBeads()
    {
        $beads = Beads::all();

        $userFavorites = Auth::user()->userFavorites;
        $data['beads'] = $beads;
        $data['finishes'] = Finishes::all();

        return view('beads.beads')->with($data);
    }

    /**
     * Get an array of all the beads for the pattern maker
     * @return array
     */
    public function allBeadsSelect()
    {
        $beads = Beads::all();

        $beadsArray = ($beads->map(function($input){
            return ['color' => '#'.dechex($input->color), 'image' => $input->image_file, 'key' => $input->id];
        }))->toArray();
        return json_encode($beadsArray);
    }

    public function finish($id)
    {

        $finish = Finishes::findOrFail($id);

        $beads = $finish->beads;

       // dd($beads);
        $userFavorites = Auth::user()->userFavorites;
        $data['beads'] = $beads;
        $data['userFavorites'] = $userFavorites;
        $data['finishes'] = Finishes::all();

        return view('beads.beads')->with($data);
    }
}
