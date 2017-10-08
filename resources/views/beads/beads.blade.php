@extends('app')

@section('content')
    <h1>Beads </h1>

    @foreach( $beads as $bead)

        <div class="col-md-2 col-sm-3 col-xs-6 bead-column">
            <a href= {{'/beads/'.$bead->id}}>
                <div class="bead-list-block card">
                    <div class="bead-name-description">
                        {{ $bead->name_description }}
                    </div>

                    <div class="bead-name">{{ $bead->name }}</div>
                    <div class="image-block">
                        <img src={{asset($bead->image())}}>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@stop