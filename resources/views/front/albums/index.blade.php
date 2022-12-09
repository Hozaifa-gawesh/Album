@php $titlePage = __('models/albums.plural') @endphp

@extends('front.layouts.master')

@section('title', $titlePage)

@section('content')
    <!-- Start Search Section -->
    @include('front.albums.components.search')
    <!-- End Search Section -->

    <!-- Start Flash Message -->
    @include('front.components.flash_msg')
    <!-- End Flash Message -->

    <!-- Start Content Body -->
    <section class="content-body mb-5">
        <div class="card">
            <div class="card-header">
                <h2>{{ $titlePage }}</h2>

                <a href="{{ route('albums.create') }}" class="btn btn-primary add-new">
                    <i class="fa-solid fa-plus"></i> @lang('models/albums.titles.add')
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 250px">@lang('models/albums.fields.name')</th>
                            <th nowrap>@lang('models/albums.fields.status')</th>
                            <th nowrap>@lang('models/albums.fields.created_at')</th>
                            <th nowrap>@lang('models/albums.fields.updated_at')</th>
                            <th nowrap>@lang('general.actions')</th>
                        </tr>
                        </thead>

                        <tbody>
                            @forelse($albums as $get)
                                <tr>
                                    <td>{{ ($albums->currentpage() - 1) * $albums->perpage() + $loop->iteration }}</td>
                                    <td nowrap>{{ str_limit($get->name ?? '', 25) }}</td>
                                    <td><span class="badge text-white bg-{{ config("status_color.{$get->status_key}") }}">{{ $get->status_name }}</span></td>
                                    <td nowrap>{{ $get->created_at->diffForHumans() }}</td>
                                    <td nowrap>{{ $get->updated_at->diffForHumans() }}</td>
                                    <td nowrap>

                                        <a href="{{ route('pictures.index', $get->id) }}" title="@lang('models/pictures.plural')" class="btn mr-2 btn-icon btn-sm btn-outline-warning position-relative">
                                            <i class="fa-solid fa-image"></i>
                                            @if($get->pictures_count)
                                                <span class="badge-count">{{ $get->pictures_count }}</span>
                                            @endif
                                        </a>


                                        <a href="{{ route('albums.edit', $get->id) }}" title="@lang('models/albums.titles.edit')" class="btn mr-2 btn-icon btn-sm btn-outline-info">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button title="@lang('models/albums.titles.delete')" data-id="{{ $get->id }}" class="btn btn-icon btn-sm btn-outline-danger btn-{{ $get->pictures_count ? 'question' : 'delete' }}">
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

               {{ $albums->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
    <!-- End Content Body -->
    <div class="loading_request">
        <img src="{{ asset('images/ajax-loader.gif') }}">
    </div>

    <input type="hidden" readonly id="ItemDelete" data-name="album" value="{{ route('albums.delete') }}">
    <input type="hidden" readonly id="AlbumSelect" value="{{ route('albums.select') }}">
@endsection
