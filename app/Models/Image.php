<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id','camera_id','image_url','image_name'
    ];

    /**
     * Get the application who's owner the this Image
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the Camera who's owner the this Image
     */
    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
