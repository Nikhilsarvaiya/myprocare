@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Opening Hours</h1>

        <a href="{{ route('admin.businesses.basic_details.create') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    @if(Session::has('alert-danger'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}"></p>

        <div
            class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                {{ Session::get('alert-danger') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
             role="alert">
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.businesses.opening_hours.store', request()->route('business')) }}">
        @csrf

        <table class="table">
            <thead>
            <tr>
                <td></td>
                <td class="dark:text-white">Start Time</td>
                <td class="dark:text-white">End time</td>
            </tr>
            </thead>
            <tbody>
            @foreach($days as $index => $day)
                <tr>
                    <td>
                        <input type="checkbox"
                               name="open[{{$index}}]" {{ isset(old('open')[$index]) && old('open')[$index] === 'on' ? 'checked' : '' }}>
                        <label class="dark:text-white" class="ms-2">{{ $day }}</label>
                    </td>
                    <td>
                        <input type="time" name="start_time[{{$index}}]"
                               value="{{ old('start_time')[$index] ?? null }}">
                    </td>
                    <td>
                        <input type="time" name="end_time[{{$index}}]" value="{{ old('end_time')[$index] ?? null }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <x-primary-button class="mt-4" type="submit">
            Next
        </x-primary-button>
    </form>
@endsection