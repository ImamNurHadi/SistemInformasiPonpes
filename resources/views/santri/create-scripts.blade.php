@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2
        $('#gedung_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Gedung',
            allowClear: true
        });

        $('#kamar_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kamar',
            allowClear: true
        });

        // Function to load kamar options
        function loadKamarOptions(gedungId) {
            if (gedungId) {
                $.ajax({
                    url: `/kamar/gedung/${gedungId}`,
                    type: 'GET',
                    success: function(response) {
                        let kamarSelect = $('#kamar_id');
                        kamarSelect.empty();
                        kamarSelect.append('<option value="">Pilih Kamar</option>');
                        
                        response.forEach(function(kamar) {
                            kamarSelect.append(`<option value="${kamar.id}">${kamar.nama_kamar}</option>`);
                        });

                        // If there's an old value, select it
                        @if(old('kamar_id'))
                            kamarSelect.val('{{ old('kamar_id') }}').trigger('change');
                        @endif
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading kamar:', error);
                    }
                });
            } else {
                $('#kamar_id').empty().append('<option value="">Pilih Kamar</option>').trigger('change');
            }
        }

        // Handle gedung selection change
        $('#gedung_id').change(function() {
            loadKamarOptions($(this).val());
        });

        // Load kamar options on page load if gedung is selected
        let selectedGedung = $('#gedung_id').val();
        if (selectedGedung) {
            loadKamarOptions(selectedGedung);
        }
    });
</script>
@endpush 