<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['application_name','user_id'];


    /**
     * Get the user who's owner the this application
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who's owner the this application
     */
    public function images()
    {
        return $this->HasMany(Image::class);
    }

    /**
     * Get the user who's owner the this application
     */
    public function cameras()
    {
        return $this->HasMany(Camera::class);
    }
}
