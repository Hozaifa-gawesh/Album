@php $titlePage = __('models/pictures.plural') @endphp

@extends('front.layouts.master')

@section('title', $titlePage)

@section('content')

    <!-- Start Flash Message -->
    @include('front.components.flash_msg')
    <!-- End Flash Message -->

    <!-- Start Content Body -->
    <section class="content-body mb-5">
        <div class="card">
            <div class="card-header">
                <h2>{{ $titlePage }}</h2>

                    <a href="{{ route('pictures.create', $album->id) }}" class="btn btn-primary add-new">
                    <i class="fa-solid fa-plus"></i> @lang('models/pictures.titles.add')
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover preview_images">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th nowrap>@lang('models/pictures.fields.picture')</th>
                            <th nowrap>@lang('models/pictures.fields.created_at')</th>
                            <th nowrap>@lang('models/pictures.fields.updated_at')</th>
                            <th nowrap>@lang('general.actions')</th>
                        </tr>
                        </thead>

                        <tbody>
                            @forelse($pictures as $get)
                                <tr>
                                    <td>{{ ($pictures->currentpage() - 1) * $pictures->perpage() + $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ asset($get->picture) }}">
                                            <img class="img-thumbnail img-table" src="{{ asset($get->picture) }}">
                                        </a>
                                    </td>
                                    <td nowrap>{{ $get->created_at->diffForHumans() }}</td>
                                    <td nowrap>{{ $get->updated_at->diffForHumans() }}</td>
                                    <td nowrap>
                                        <button title="@lang('models/pictures.titles.delete')" data-id="{{ $get->id }}" class="btn btn-icon btn-sm btn-outline-danger btn-{{ $get->pictures_count ? 'question' : 'delete' }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="10">{{ __('general.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

               {{ $pictures->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
    <!-- End Content Body -->
    <div class="loading_request">
        <img src="{{ asset('images/ajax-loader.gif') }}">
    </div>

    <input type="hidden" readonly id="ItemDelete" data-name="picture" value="{{ route('pictures.delete') }}">
@endsection
