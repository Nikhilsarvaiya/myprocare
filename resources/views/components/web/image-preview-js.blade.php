@props([
    'elId' => 'image',
    'elPreviewId' => 'preview-image'
])

@push('script')
    <script>
        const elId = '{{ $elId }}';
        const elPreviewId = '{{ $elPreviewId }}';

        document.getElementById(elId).onchange = (event) => {
            const preview = document.getElementById(elPreviewId);
            preview.style.display = 'block';

            const [file] = event.target.files;
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
