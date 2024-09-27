@extends('layouts.app')

@section('main')
    <div class="space-y-6 pb-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('My QR') }}
                </h2>

                <div class="mt-4 inline-flex p-2 bg-gray-100 dark:bg-white">
                    {!! QrCode::size(200)->generate(Auth::id()); !!}
                </div>
            </div>
        </div>
    </div>
@endsection
