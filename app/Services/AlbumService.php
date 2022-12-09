<?php


namespace App\Services;


use App\Constants\ConstantsGeneral;
use App\Http\Traits\UploadFiles;
use App\Models\Album;

class AlbumService
{

    use UploadFiles;

    protected Album $model;

    public function __construct(Album $model)
    {
        $this->model = $model;
    }


    /**
     * Albums List
     * @param array $request
     * @param bool $paginate
     * @param array $relation
     * @param array $withCount
     * @return mixed
     */
    public function albumsList(array $request = [], bool $paginate = true, array $withCount = [], array $relation = [])
    {
        // Set Query
        $query = $this->mainQuery($request, $withCount, $relation);
        return $paginate ? ($query->paginate($request['pagination'] ?? ConstantsGeneral::PAGINATION_ITEMS_COUNT)) : $query->get();
    }


    /**
     * Get Albums Without Specific Album ID
     * @param int $album_id
     * @return mixed
     */
    public function albumsWithoutSpecificId(int $album_id)
    {
        return $this->mainQuery()->where('id', '<>', $album_id)->get();
    }


    /**
     * Albums Status
     * @return array
     */
    public function statusAlbums() : array
    {
        return Album::STATUS_ALBUM;
    }


    /**
     * Store Album in DB
     * @param array $data
     * @return mixed
     */
    public function storeAlbum(array $data)
    {
        return $this->model->create($data);
    }


    /**
     * Get Album By ID
     * @param $album_id
     * @return mixed
     */
    public function getAlbumById($album_id)
    {
        return $this->model->findOrFail($album_id);
    }


    /**
     * Update Album in DB
     * @param int $album_id
     * @param array $data
     * @return mixed
     */
    public function updateAlbum(int $album_id, array $data)
    {
        return $this->getAlbumById($album_id)->update($data);
    }


    /**
     * Delete Album From DB
     * @param int $album_id
     * @param bool $delete_pictures
     */
    public function forceDeleteAlbum(int $album_id, bool $delete_pictures = false)
    {
        // Get Album Information
        $album = $this->getAlbumById($album_id);
        // Delete All Pictures Related to Album
        if($delete_pictures) {
            $this->deleteFile($album->pictures->pluck('picture')->toArray());
        }
        // Delete Album
        $album->forceDelete();
    }


    /**
     * Delete Album And Move Pictures To Another Album
     * @param array $request
     * @return array
     */
    public function deleteAlbumAndMovePictures(array $request) : array
    {
        // Get Albums By Ids
        $albums = $this->model->whereIn('id', $request)->get();
        $excluded_album = $albums->firstWhere('id', $request['excluded_album']);
        $album = $albums->firstWhere('id', $request['album']);
        // Update album id to the album request
        $excluded_album->pictures()->update(['album_id' => $album->id]);
        // delete album excluded
        $excluded_album->forceDelete();
        return ['excluded' => $excluded_album->name, 'album' => $album->name];
    }


    /**
     * Main Query Database
     * @param array $request
     * @param array $withCount
     * @param array $withRelation
     * @return mixed
     */
    public function mainQuery(array $request = [], array $withCount = [], array $withRelation = [])
    {
        return $this->model->orderBy('id', ($request['sort_by'] ?? 'desc'))
            // Search By Name
            ->when(request()->filled('name'), function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request['name'] . '%');
            })
            // Filter By Sta    tus
            ->when(request()->filled('status'), function ($query) use ($request) {
                $query->{$request['status']}();
            })

            // With Relations Count
            ->when(count($withCount), function ($query) use ($withCount) {
                $query->withCount($withCount);
            })
            // With Relations
            ->when(count($withRelation), function ($query) use ($withRelation) {
                $query->with($withRelation);
            });
    }

}
