@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Edit Advertisement'"/>

        <a href="{{ route('admin.advertisements.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.advertisement-create-edit
        :type="'edit'"
        :url="route('admin.advertisements.update', $advertisement->id)"
        :method="'PUT'"
        :advertisement="$advertisement"
    />
@endsection
