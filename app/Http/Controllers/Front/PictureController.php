<?php

namespace App\Http\Controllers\Front;

use App\Constants\ConstantsGeneral;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Pictures\StorePictures;
use App\Http\Requests\General\DeleteItemRequest;
use App\Http\Traits\ApiResponse;
use App\Services\AlbumService;
use App\Services\PictureService;

class PictureController extends Controller
{

    use ApiResponse;

    protected PictureService $pictureService;

    protected AlbumService $albumService;

    protected string $viewPath = 'front.pictures.';


    public function __construct(PictureService $pictureService, AlbumService $albumService)
    {
        $this->pictureService = $pictureService;
        $this->albumService = $albumService;
    }


    /**
     * List of Pictures By Album ID
     * @param $album_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($album_id)
    {
        // Album Information
        $album = $this->albumService->getAlbumById($album_id);
        // Pictures List Related To Album
        $pictures = $this->pictureService->picturesListRelatedAlbumID($album->id);
        return view($this->viewPath . 'index', compact('album', 'pictures'));
    }


    /**
     * Display Create Page
     * @param $album_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($album_id)
    {
        // Album Information
        $album = $this->albumService->getAlbumById($album_id);
        $max_file_upload = ConstantsGeneral::MAX_FILES_UPLOAD;
        return view($this->viewPath . 'create', compact('album', 'max_file_upload'));
    }


    /**
     * Insert Data in DB
     * @param StorePictures $request
     * @param $album_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePictures $request, $album_id)
    {
        // Album Information
        $album = $this->albumService->getAlbumById($album_id);
        // Insert Pictures In DB
        $this->pictureService->storePicture($album, $request->validated());
        flash('success', __('general.stored', ['key' => __('models/pictures.plural')]));
        return redirect(route('pictures.index', $album->id));
    }


    /**
     * Delete Album
     * @param DeleteItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteItemRequest $request)
    {
        // Delete Picture
        $this->pictureService->forceDeletePicture($request->item);
        $msg = __('general.deleted', ['key' => __('models/pictures.singular')]);
        return $this->successResponse([], $msg);
    }
}
