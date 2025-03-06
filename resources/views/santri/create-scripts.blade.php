@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2
        $('#komplek_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Komplek',
            allowClear: true
        });

        $('#kamar_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kamar',
            allowClear: true
        });

        // Function to load kamar options
        function loadKamarOptions(komplekId) {
            if (komplekId) {
                $.ajax({
                    url: `/kamar/komplek/${komplekId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let kamarSelect = $('#kamar_id');
                        kamarSelect.empty();
                        kamarSelect.append('<option value="">Pilih Kamar</option>');
                        
                        data.forEach(function(kamar) {
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

        // Handle komplek selection change
        $('#komplek_id').change(function() {
            loadKamarOptions($(this).val());
        });

        // Load kamar options on page load if komplek is selected
        let selectedKomplek = $('#komplek_id').val();
        if (selectedKomplek) {
            loadKamarOptions(selectedKomplek);
        }
    });
</script>
@endpush 