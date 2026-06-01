<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    protected $table = 'project_media'; // لتحديد اسم الجدول بدقة
    protected $fillable = ['project_id', 'file_path', 'medianame'];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
