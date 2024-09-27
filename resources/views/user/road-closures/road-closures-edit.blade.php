@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Edit Road Closure'"/>

        <a href="{{ route('user.road-closures.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.road-closure-create-edit
        :url="route('user.road-closures.update', $road_closure->id)"
        :method="'put'"
        :road_closure="$road_closure"
    />
@endsection
