@extends('layouts.app')

@section('content')
    @include('partials.header')
    @include('partials.exercises-carousel')
    @include('partials.calendar')
    @include('partials.modals')
@endsection

@push('scripts')
    @include('partials.scripts')
@endpush