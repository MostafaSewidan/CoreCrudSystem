<?php

namespace Modules\Core\Traits\Attachment;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


trait Attachment
{

    private $imageExtensions = [
        'jpg',
        'jpeg',
        'png',
        'svg',
        'rgb',
    ];

    /**
     * @param $key
     * @param $array
     * @param $value
     * @return mixed
     */
    private static function inArray($key, $array, $value)
    {
        $return = array_key_exists($key, $array) ? $array[$key] : $value;
        return $return;
    }

    /**
     * @param $file
     * @param $folder_name
     * @param null $model
     * @param null $col_name
     * @param array $options
     * @return string
     */
    public static function addAttachment($file, $folder_name, $model = null, $col_name = null, array $options = [])
    {
        $save = self::inArray('save', $options, 'original');
        $size = self::inArray('size', $options, 400);
        $quality = self::inArray('quality', $options, 100);
        $folder_name = $folder_name . '/' . Carbon::now()->toDateString();

        ///////////////////////////////

        $destinationPath = public_path() . '/uploads/' . $folder_name . '/';
        $extension = $file->getClientOriginalExtension(); // getting image extension

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755);
        }

        if ($extension == 'svg' || $save == 'original'):

            $image = $save . '-' . time() . '' . rand(11111, 99999) . '.' . $extension;
            $file->move($destinationPath, $image); // uploading file to given
            $path = 'uploads/' . $folder_name . '/' . $image;
        else:
            $imageResize = self::resizePhoto($extension, $destinationPath, $file, $size, $quality);
            $path = 'uploads/' . $folder_name . '/' . $imageResize;
        endif;

        if ($model):
            $model->$col_name = $path;
            $model->save();
        endif;

        return $path;
    }

    /**
     * @param $file
     * @param $oldFilesPath
     * @param $folder_name
     * @param null $model
     * @param null $col_name
     * @param array $options
     * @return string
     */
    public static function updateAttachment($file, $oldFilesPath, $folder_name, $model = null, $col_name = null, array $options = [])
    {
        self::deleteAttachment($oldFilesPath);
        return self::addAttachment($file,$folder_name,$model,$col_name,$options);
    }

    /**
     * @param $file_path
     * @return bool
     */
    public static function deleteAttachment($file_path)
    {
        foreach ((array)$file_path as $file) {
            File::delete(public_path() . '/' . $file);
        }
        return true;
    }

    /**
     * @param $extension
     * @param string $destinationPath
     * @param $file
     * @param int $size
     * @param int $quality
     * @return string
     */
    private static function resizePhoto($extension, $destinationPath, $file, $size = 400, $quality = 100)
    {
        $image = $size . '-' . time() . '' . rand(11111, 99999) . '.' . $extension;

        $resize_image = Image::make($file);
        $resize_image->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . $image, $quality);

        return $image;
    }
}
