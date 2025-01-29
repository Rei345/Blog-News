<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $table = "comment_replies";

    protected $primaryKey = "id";

    protected $fillable = ["id_comment", "commentable_id", "commentable_type", "reply"];

    public function replies()
    {
        return $this->hasMany(CommentReply::class, 'id_comment');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_comment');
    }
}
