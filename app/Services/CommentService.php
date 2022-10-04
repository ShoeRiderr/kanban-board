<?php

namespace App\Services;

use App\Models\KanbanBoard\Comment;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CommentService
{
    public function update(Comment $comment, array $data = [])
    {
        $files = Arr::get($data, 'files', []);
        $commentFiles = $comment->files;

        $attachedFiles = array_filter($files, function ($file) {
            return !($file instanceof UploadedFile);
        });

        foreach ($commentFiles as $commentFile) {
            if (!in_array($commentFile->id, $attachedFiles)) {
                $comment->files()->where('id', $commentFile->id)->delete();
            }
        }

        return $comment->update([
            'content' => $data['content'],
        ]);
    }
}
