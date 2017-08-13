<?php

namespace App\Http\Controllers\Beads;

use App\userFavorites;
use Illuminate\Http\Request;

use App\Beads;
use App\Finishes;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return $this->mapBeadsForDisplay($beads);
    }

    public function byFinishSelect()
    {
        $finishes = Input::get('finishes');

        if (!$finishes)
            return [];

        $beads = Beads::join('beads_finishes', 'beads_finishes.beads_id', '=', 'beads.id')
            ->whereIn('beads_finishes.finishes_id', $finishes)
            ->get();

        //todo: this should be ordered so beads with multiple of the marked off finishes come first
        return $this->mapBeadsForDisplay($beads);
    }

    public function byColorSelect()
    {
        $color = json_decode(Input::get('color'));

        if (!$color)
            return [];

        $beads = Beads::join('beads_finishes', 'beads_finishes.beads_id', '=', 'beads.id')
            ->get();

        $filteredBeads = $beads->reject(function ($input) use ($color) {
            return ((2 * ($input->red - $color->r) * ($input->red - $color->r) +
                    4 * (($input->green - $color->g) * ($input->green - $color->g)) +
                    3 * (($input->blue - $color->b) * ($input->blue - $color->b))) > 8000);
        });

        return $this->mapBeadsForDisplay($filteredBeads);
    }

    public function byIdSelect()
    {
        $keys = json_decode(Input::get('keys'));

        if (!$keys)
            return [];

        $beads = Beads::join('beads_finishes', 'beads_finishes.beads_id', '=', 'beads.id')
            ->whereIn('beads.id', $keys)
            ->get();

        return $this->mapBeadsForDisplay($beads);
    }


    private function mapBeadsForDisplay($beads)
    {
        $beadsArray = ($beads->map(function ($input) {
            return ['color' => '#' . dechex($input->color), 'image' => $input->image_file, 'key' => $input->id];
        }))->toArray();
        return json_encode($beadsArray);
    }
}
