@extends('layouts.app')

@section('content')
    <form role="form" method="POST" action="{{ route('addLot') }}">
        {{ csrf_field() }}

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="form-group row">
            <label for="currency_id" class="col-sm-2 col-form-label">Currency ID</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="currency_id" type="text"
                       name="currency_id"
                       value="{{ old('currency_id') }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="seller_id" class="col-sm-2 col-form-label">Seller ID</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="seller_id"
                       type="text"
                       name="seller_id"
                       value="{{ old('seller_id') }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="short-name" class="col-sm-2 col-form-label">Short name</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="short-name"
                       type="text"
                       name="short_name"
                       value="{{ old('short_name') }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="date_time_open" class="col-sm-2 col-form-label">Date time open</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="date_time_open"
                       type="text"
                       name="date_time_open"
                       value="{{ old('date_time_open') }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="date_time_close" class="col-sm-2 col-form-label">Date time close</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="date_time_close"
                       type="text"
                       name="date_time_close"
                       value="{{ old('date_time_close') }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="price" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input class="form-control"
                       id="price" type="text"
                       name="price"
                       value="{{ old('price') }}">
            </div>
        </div>

        <div>
            <button class="btn btn-success" type="submit">Add</button>
        </div>
    </form>
@endsection
