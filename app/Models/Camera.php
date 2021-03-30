<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;

    protected $fillable = [
        'camera_name','application_id'
    ];

    /**
     * Get the application who's owner the this Image
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
