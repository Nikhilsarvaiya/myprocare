@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Scan Customer'"/>

        <a href="{{ route('user.businesses.wallet-transactions.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <div id="reader" class="w-full sm:max-w-xl h-auto object-fit"></div>
@endsection

@push('script')
    <script type="module">
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: 250 },
        );

        html5QrcodeScanner.render(onScanSuccess, onScanError);

        function onScanSuccess(decodedText) {
            let url = '{{route('user.businesses.wallet-transactions.create', ['user' => ':userId', 'type' => ':transactionType'])}}';

            url = url.replace(':userId', decodedText);
            url = url.replace(':transactionType', '{{ request('type') }}');

            window.location.href = url;
        }

        function onScanError(decodedText) {
            //console.log(decodedText);
        }
    </script>

@endpush
