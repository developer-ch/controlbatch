@push('scripts')
    <script>
        @if (session('success'))
            M.toast({
                html: "{{ session('success') }}",classes: 'rounded green close'
            })
        @endif
        @if (session('warning'))
            M.toast({
                html: "{{ session('warning') }}",classes: 'rounded orange close'
            })
        @endif

        @if (session('error'))
            M.toast({
                html: "{{ session('error') }}",classes: 'rounded red close'
            })
        @endif
    </script>
@endpush
