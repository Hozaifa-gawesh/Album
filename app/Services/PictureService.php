<?php


namespace App\Services;


use App\Constants\ConstantsGeneral;
use App\Http\Traits\UploadFiles;
use App\Models\Picture;

class PictureService
{

    use UploadFiles;

    protected Picture $model;

    protected string $path = 'pictures';

    public function __construct(Picture $model)
    {
        $this->model = $model;
    }


    /**
     * Pictures List
     * @param array $request
     * @param bool $paginate
     * @return mixed
     */
    public function picturesList(array $request = [], bool $paginate = true)
    {
        $query = $this->mainQuery();
        return $paginate ? ($query->paginate($request['pagination'] ?? ConstantsGeneral::PAGINATION_ITEMS_COUNT)) : $query->get();
    }


    /**
     * Pictures List By Album ID
     * @param int $album_id
     * @param array $request
     * @param bool $paginate
     * @return mixed
     */
    public function picturesListRelatedAlbumID(int $album_id, array $request = [], bool $paginate = true)
    {
        $query = $this->mainQuery()->whereAlbumId($album_id);
        return $paginate ? ($query->paginate($request['pagination'] ?? ConstantsGeneral::PAGINATION_ITEMS_COUNT)) : $query->get();
    }


    /**
     * Store Pictures in DB
     * @param $album
     * @param $data
     */
    public function storePicture($album, $data)
    {
        $pictures = [];
        foreach ($data['pictures'] as $picture) {
            $pictures[]['picture'] = $this->uploadFile($picture, $this->path);
        }
        // Store Pictures in DB
        $album->pictures()->createMany($pictures);
    }


    /**
     * Get Picture Details
     * @param $picture_id
     * @return mixed
     */
    public function getPictureById($picture_id)
    {
        return $this->model->findOrFail($picture_id);
    }


    /**
     * Delete Picture From DB
     * @param int $picture_id
     */
    public function forceDeletePicture(int $picture_id)
    {
        // Get Picture Information
        $picture = $this->getPictureById($picture_id);
        $this->deleteFile($picture->picture);
        // Delete Picture
        $picture->forceDelete();
    }


    /**
     * Main Query Pictures
     * @return mixed
     */
    public function mainQuery()
    {
        return $this->model->latest('id');
    }
}
