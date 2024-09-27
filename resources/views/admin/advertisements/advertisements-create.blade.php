@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Create Advertisement'"/>

        <a href="{{ route('admin.advertisements.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.advertisement-create-edit :url="route('admin.advertisements.store')"/>
@endsection
