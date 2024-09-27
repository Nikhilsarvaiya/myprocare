@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Create Road Closure</h1>

        <a href="{{ route('user.road-closures.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.road-closure-create-edit :url="route('user.road-closures.store')"/>
@endsection
