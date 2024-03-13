<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoEnlace extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'tipo', 'url', 'caido'];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
