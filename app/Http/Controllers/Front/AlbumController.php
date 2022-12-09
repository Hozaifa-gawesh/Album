<?php

namespace App\Http\Controllers\Front;

use App\Constants\ConstantsGeneral;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Album\AlbumListRequest;
use App\Http\Requests\Front\Album\CheckAlbumRequest;
use App\Http\Requests\Front\Album\StoreAlbum;
use App\Http\Requests\General\DeleteItemRequest;
use App\Http\Traits\ApiResponse;
use App\Services\AlbumService;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    use ApiResponse;

    protected AlbumService $albumService;

    protected string $viewPath = 'front.albums.';

    protected string $route;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
        $this->route = route('albums.index');
    }


    /**
     * List of Albums
     * @param AlbumListRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(AlbumListRequest $request)
    {
        // Albums List
        $albums = $this->albumService->albumsList($request->validated(), true, ['pictures']);
        // Album Status
        $status_album = $this->albumService->statusAlbums();
        // Sort Array
        $sort = ConstantsGeneral::SORTING;
        return view($this->viewPath . 'index', compact('albums', 'status_album', 'sort'));
    }


    /**
     * Albums List Modal
     * @return \Illuminate\Http\JsonResponse
     */
    public function albums()
    {
        $album_id = request('album');
        // Albums List
        $albums = $this->albumService->albumsWithoutSpecificId($album_id);
        return $this->successResponse(view($this->viewPath . '.components.choose-album', compact('album_id', 'albums'))->render());
    }


    /**
     * Delete Album And Move Pictures
     * @param CheckAlbumRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function move(CheckAlbumRequest $request)
    {
        DB::beginTransaction();
        $albums = $this->albumService->deleteAlbumAndMovePictures($request->validated());
        DB::commit();
        // Flash Messages
        flash('success', __('models/albums.messages.moved_and_delete', ['album' => $albums['album'], 'excluded_album' => $albums['excluded']]));
        return redirect($this->route);
    }


    /**
     * Display Create Page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Album Status
        $status = $this->albumService->statusAlbums();
        return view($this->viewPath . 'create', compact('status'));
    }


    /**
     * Insert Data in DB
     * @param StoreAlbum $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreAlbum $request)
    {
        $this->albumService->storeAlbum($request->validated());
        flash('success', __('general.stored', ['key' => __('models/albums.singular')]));
        return redirect($this->route);
    }


    /**
     * Display Edit Page
     * @param int $album_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $album_id)
    {
        // Album Information
        $album = $this->albumService->getAlbumById($album_id);
        // Album Status
        $status = $this->albumService->statusAlbums();
        return view($this->viewPath . 'edit', compact('album', 'status'));
    }


    /**
     * Update Data In DB
     * @param StoreAlbum $request
     * @param int $album_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreAlbum $request, int $album_id)
    {
        $this->albumService->updateAlbum($album_id, $request->validated());
        flash('success', __('general.updated', ['key' => __('models/albums.singular')]));
        return redirect($this->route);
    }


    /**
     * Delete Album
     * @param DeleteItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteItemRequest $request)
    {
        // Delete Album
        $this->albumService->forceDeleteAlbum($request->item, true);
        $msg = __('general.deleted', ['key' => __('models/albums.singular')]);
        return $this->successResponse([], $msg);
    }

}
