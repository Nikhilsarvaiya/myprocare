@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Event Edit</h1>

        <a href="{{ route('user.events.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.event-create-edit
        :url="route('user.events.update', $event->id)"
        :method="'PUT'"
        :event="$event"
    />
@endsection