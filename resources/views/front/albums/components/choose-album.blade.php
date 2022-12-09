<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('albums.move') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalLabel">Move pictures to another album</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="album" class="form-label">@lang('models/albums.singular') <span class="text-danger">*</span></label>
                            <select required class="form-control" id="album" name="album">
                                <option value="">@lang('general.choose') @lang('models/albums.singular')</option>
                                @foreach ($albums as $get)
                                    <option value="{{ $get->id }}" {{ old('album') == $get->id ? 'selected' : '' }}>{{ $get->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" readonly name="excluded_album" value="{{ $album_id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('general.close')</button>
                    <button type="submit" id="submit" class="btn btn-primary">@lang('models/albums.titles.move_pictures')</button>
                </div>
            </form>
        </div>
    </div>
</div>
