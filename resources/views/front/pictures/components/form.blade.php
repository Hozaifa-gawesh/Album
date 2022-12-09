@csrf
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="picture" class="form-label">@lang('models/pictures.fields.picture') <span class="text-danger">Max files upload ({{ $max_file_upload }})</span></label>
                    <input required type="file" accept="image/png, image/jpeg, image/gif" multiple
                           class="filepond @error('picture') is-invalid @enderror"
                           id="picture"
                           name="pictures[]"
                           placeholder="@lang('general.choose') @lang('models/pictures.fields.picture')"
                           data-max-files="{{ $max_file_upload }}"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row search-actions">
    <div class="col-md-12">
        <button type="submit" id="submit" class="btn btn-primary">
            <i class="fa-regular fa-floppy-disk"></i>
            @lang('general.submit')
        </button>
        &nbsp;&nbsp;

        <a href="{{ route('pictures.index', $album->id) }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-xmark"></i>
            @lang('general.cancel')
        </a>
    </div>
</div>

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/filepond.min.css') }}">
@endsection

@section('js')
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="{{ asset('assets/js/filepond.min.js') }}"></script>



    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImageValidateSize);
        FilePond.registerPlugin(FilePondPluginFileValidateType);


        // get a reference to the input element
        const inputElement = document.querySelector('.filepond');

        // create a FilePond instance at the input element location
        const pond = FilePond.create(inputElement, {
            // maxFiles: 10,
            allowImageValidateSize: true,
            checkValidity: true,
            allowFileTypeValidation: true,
            allowMultiple: true,
            storeAsFile: true,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
        });
    </script>
@endsection
