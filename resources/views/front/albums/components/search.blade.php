<section class="search mb-5">
    <div class="search-content">
        <!-- Start Card -->
        <div class="card">
            <div class="card-header">
                <h2>@lang('general.search')</h2>
            </div>

            <div class="card-body">
                <form method="get" action="{{ route('albums.index') }}" id="searchForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">@lang('models/albums.fields.name')</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="@lang('general.enter') @lang('models/albums.fields.name')">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">@lang('models/albums.fields.status')</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">@lang('general.choose') @lang('models/albums.fields.status')</option>
                                            @foreach ($status_album as $value)
                                                <option value="{{ $value }}" {{ old('status', request('status')) == $value ? 'selected' : '' }}>{{ __('status.' . $value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('general.records')</label>
                                        <select name="paginate" class="form-control datatable-input" data-col-index="2">
                                            <option value="" selected>{{ __('general.choose') }} @lang('general.records')</option>
                                            @for($record = 10; $record <= 100; $record+=10)
                                                <option value="{{ $record }}" {{ old('paginate', request('paginate') ?? $albums->perPage()) == $record ? 'selected' : '' }}>{{ $record }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('general.sort_by')</label>
                                        <select name="sort_by" class="form-control datatable-input" data-col-index="2">
                                            @foreach ($sort as $value)
                                                <option value="{{ $value }}" {{ old('sort_by', request('sort_by') ?? 'desc') == $value ? 'selected' : '' }}>{{ __('general.' . $value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row search-actions">
                        <div class="col-md-12">
                            <button type="submit" id="submit" class="btn btn-search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                @lang('general.search')
                            </button>
                            &nbsp;&nbsp;

                            <a href="{{ route('albums.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-xmark"></i>
                                @lang('general.reset')
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
