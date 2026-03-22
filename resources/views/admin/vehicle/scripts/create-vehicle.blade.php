<script>
    $(document).ready(function () {
        let vehicleCount = 1;
        $('#addVehicle').click(function () {
            const vehicleFormContainer = $('#vehicleFormsContainer');
            const formTemplate = vehicleFormContainer.children().first().clone();

            formTemplate.find('input, select, textarea').each(function () {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace('[0]', '[' + vehicleCount + ']');
                    $(this).attr('name', newName);
                }

                const id = $(this).attr('id');
                if (id) {
                    const newId = id + '-' + vehicleCount;
                    $(this).attr('id', newId);
                }

                if ($(this).is('input') || $(this).is('textarea')) {
                    $(this).val('');
                }

                if ($(this).is('select')) {
                    $(this).prop('selectedIndex', 0);
                }
            });

            const defaultImagePath = '{{ asset(config('custom.images.default')) }}';
            formTemplate.find('img.add-image-ckfinder').each(function () {
                const oldId = $(this).attr('id');
                const newId = oldId.replace(/-\d+$/, '-' + vehicleCount);
                $(this).attr('id', newId);
                $(this).attr('src', defaultImagePath);

                const dataInput = $(this).attr('data-input');
                if (dataInput) {
                    const newDataInput = dataInput.replace(/\[\d+\]/, '[' + vehicleCount + ']');
                    $(this).attr('data-input', newDataInput);
                }

                const dataPreview = $(this).attr('data-preview');
                if (dataPreview) {
                    const newDataPreview = dataPreview.replace(/-\d+/, '-' + vehicleCount);
                    $(this).attr('data-preview', newDataPreview);
                }
            });
            vehicleFormContainer.append(formTemplate);
            // Phá hủy CKEditor cũ trước khi khởi tạo lại
            if (CKEDITOR.instances['ckeditor-' + vehicleCount]) {
                CKEDITOR.instances['ckeditor-' + vehicleCount].destroy(true);
            }
            setTimeout(function() {
                formTemplate.find('textarea.ckeditor').each(function () {
                    const newId = 'ckeditor-' + vehicleCount;
                    $(this).attr('id', newId);
                    CKEDITOR.replace(newId);
                });
            }, 0);
            vehicleCount++;
        });
    });

</script>
