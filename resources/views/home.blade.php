@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <side-bar></side-bar>
        </div>
        <div class="col-sm-12 col-md-9 row">
            {{-- <folder-list></folder-list> --}}
            <card-list></card-list>
        </div>
    </div>
</div>


@endsection
