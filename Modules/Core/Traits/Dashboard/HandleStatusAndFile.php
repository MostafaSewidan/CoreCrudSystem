<?php
namespace Modules\Core\Traits\Dashboard;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Modules\Core\Traits\Attachment\Attachment;

/**
 * Handle status and file which uploaded
 */
trait HandleStatusAndFile
{

    /**
     * Status attribute in model
     * @var array
     */
    protected array $statusAttribute = [
        "status"
    ];

    /**
    * Status attribute in model
    * @var array
    */
    protected $fileAttribute = [
        "image"     => "images"
    ];

    /**
     * Status attribute in model
     * @var array
     */
    protected $largeFile = [];



    /**
     * Handle Status in statusAttribute
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function handleStatusInRequest(Request $request) :array
    {
        $statusData = [];
        foreach ($this->statusAttribute as $status) {
            if (property_exists($this->model, 'fillable') && in_array($status, $this->model->getfillable())) {
                $statusData[$status] = ($request->{$status} ? 1 : 0);
            }
        }

        return $statusData;
    }


    /**
     * Handle files in Request
     *
     * @param mixed $model
     * @param \Illuminate\Http\Request $request
     * @param bool $delteBeforeUpdate for delete the file firest
     * @return void
     */
    public function handleFileAttributeInRequest($model, Request $request, bool $delteBeforeUpdate=false) :void
    {
        if ($model instanceof HasMedia) {
            $this->handleFileIfMediaImplement($model, $request, $delteBeforeUpdate);
        } else {
            $this->handleFileNoraml($model, $request, $delteBeforeUpdate);
        }
    }

    /**
     * Handle files in Request if implemnts media
     *
     * @param mixed $model
     * @param \Illuminate\Http\Request $request
     * @param bool $delteBeforeUpdate for delete the file firest
     * @return void
     */
    public function handleFileIfMediaImplement($model, Request $request, bool $delteBeforeUpdate = false): void
    {
        foreach ($this->fileAttribute as $file => $collection) {
            if ($request->$file) {

                if ($delteBeforeUpdate == true) {
                    $model->clearMediaCollection($collection);
                }

                if (is_array($request->$file)) {
                    foreach ($request->$file as $requestFile) {
                        if ($file && is_file($file)) {
                            if (in_array($file, $this->largeFile)) {
                                $model->addMedia($requestFile)->toMediaCollection($collection, 'local');
                            } else {

                                $model->addMedia($requestFile)->toMediaCollection($collection);
                            }
                        }
                    }
                } else {
                    if ($file) {
                        if (in_array($file, $this->largeFile)) {

                            $model->addMedia($request->file($file))->toMediaCollection($collection, 'local');
                        } else {

                            $model->addMedia($request->file($file))->toMediaCollection($collection);
                        }
                    }
                }
            }
        }
    }

    /**
     * Handle files in Request if implemnts media
     * @param mixed $model
     * @param \Illuminate\Http\Request $request .
     * @param bool $delteBeforeUpdate for delete the file firest
     * @return void
     */
    public function handleFileNoraml($model, Request $request, bool $delteBeforeUpdate=false):void
    {
        foreach ($this->fileAttribute as $file => $attribute) {
            if ($request->file($file)) {
                if ($delteBeforeUpdate == true) {
                    Attachment::deleteAttachment($model->{$attribute});
                }

                Attachment::addAttachment($request->file($file), $model->getTable(), $model, $attribute);
            }
        }
    }

    /**
     * Delete file for model
     *
     * @param mixed $model
     * @return void
     */
    public function deleteFiles($model):void
    {
        if ($model instanceof HasMedia) {
            $model->clearMediaCollection();
        } else {
            foreach ($this->fileAttribute as $file => $attribute) {
                Attachment::deleteAttachment($model->{$attribute});
            }
        }
    }
}
