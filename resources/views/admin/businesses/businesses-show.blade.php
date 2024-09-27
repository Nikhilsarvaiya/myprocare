@extends('layouts.app')

@section('main')
    <x-web.business-datails :business="$business" :back-url="route('admin.businesses.index')"/>
@endsection
