<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $table = "comment_likes";

    protected $primaryKey = "id";

    protected $fillable = ["id_comment", "commentable_id", "commentable_type"];

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_comment');
    }
}
