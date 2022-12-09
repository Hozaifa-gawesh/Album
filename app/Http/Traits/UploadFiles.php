<?php


namespace App\Http\Traits;


use Illuminate\Support\Facades\File;

trait UploadFiles
{
    protected string $pathImages = 'uploads/';


    public function uploadFile($file, $path, $oldFile = null)
    {
        if($file) {
            // Rename File
            $rename = $file->hashName();
            // Path File
            $fullPath = $file->storeAs($this->pathImages . $path, $rename, 'public_media');
            // Delete Old Files
            if($oldFile) {
                $this->deleteFile($oldFile);
            }
            return $fullPath;
        }
        return $oldFile;
    }



    /**
     * Delete Images from folders
     * @param $image
     * @return bool
     */
    public function deleteFile($image)
    {
        if(is_array($image)) {
            foreach ($image as $img) {
                $this->destroyFile($img);
            }
        } else {
            $this->destroyFile($image);
        }

        return true;
    }

    private function destroyFile($file)
    {
        // Delete Image from images folder
        File::delete($file);
    }

}
