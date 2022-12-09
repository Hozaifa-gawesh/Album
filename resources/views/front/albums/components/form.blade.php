@csrf
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="name" class="form-label">@lang('models/albums.fields.name') <span class="text-danger">*</span></label>
                    <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $album->name ?? '') }}" placeholder="@lang('general.enter') @lang('models/albums.fields.name')">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="status" class="form-label">@lang('models/albums.fields.status') <span class="text-danger">*</span></label>
                    <select required class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        @foreach ($status as $key => $value)
                            <option value="{{ $key }}" {{ old('status', $album->status ?? 1) == $key ? 'selected' : '' }}>{{ __('status.' . $value) }}</option>
                        @endforeach
                    </select>
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

        <a href="{{ route('albums.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-xmark"></i>
            @lang('general.cancel')
        </a>
    </div>
</div>
