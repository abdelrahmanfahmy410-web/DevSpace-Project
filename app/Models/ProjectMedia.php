<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
   
    protected $table = 'project_media';

   
    protected $fillable = ['project_id', 'medianame', 'file_path', 'media_type'];

        /**
         *  Get the project that owns the media.
         */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
