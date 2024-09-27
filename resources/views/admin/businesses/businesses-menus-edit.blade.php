@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Menu Edit</h1>

        @php
            if (request()->route('redirect') === "edit"){
                $backUrl = route('admin.businesses.menus.edit.index', request()->route('business'));
            }else{
                $backUrl = route('admin.businesses.menus.create.index', request()->route('business'));
            }
        @endphp

        <a href="{{ $backUrl }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.menu-create-edit
        :url="route('admin.businesses.menus.update', ['business' => request()->route('business'), 'menu' => $menu->id, 'redirect' => request('redirect')])"
        :method="'PUT'"
        :menu="$menu"
    />
@endsection
