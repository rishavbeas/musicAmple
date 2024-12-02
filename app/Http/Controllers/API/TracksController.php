<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\UsersResource;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Report;
use App\Models\Track;
use App\Models\View;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TracksController extends Controller
{
    use HttpResponses;
    public function addView($id)
    {
        $track = Track::select('id')->where('id', $id)->get()->count();
        if ($track > 0) {
            Track::where('id', $id)->increment('views', 1);
            if (auth('sanctum')->check()) {
                View::create([
                    'track' => $id,
                    'by' => auth('sanctum')->user()->id
                ]);
            }
            return $this->sendResponse('', 'success');
        }
    }
    public function addDownload($id)
    {
        $track = Track::select('id')->where('id', $id)->get()->count();
        if ($track > 0) {
            Track::where('id', $id)->increment('downloads', 1);
            if (auth('sanctum')->check()) {
                Download::create([
                    'track' => $id,
                    'by' => auth('sanctum')->user()->id
                ]);
            }
            return $this->sendResponse('', 'success');
        }
    }
    public function addLikes(Request $request)
    {
        //Type 1 : Like, Type 2: Dislike
        if ($request->type == 1) {
            $track = Track::where('id', $request->track_id)->get()->count();
            if ($track > 0) {
                // Verify the Like state
                $verify = $this->verifyLike($request->track_id);
                if (!$verify) {
                    Track::where('id', $request->track_id)->increment('likes', 1);
                    if (auth('sanctum')->check()) {
                        Like::create([
                            'track' => $request->track_id,
                            'by' => auth('sanctum')->user()->id
                        ]);
                    }
                    return $this->sendResponse(true, 'Like');
                } else {
                    return $this->sendResponse(true, 'You\'ve already liked this track.');
                }
            }
        } else {
            return $this->disLikes($request->track_id);
        }
    }
    public function addComment(Request $request, $id)
    {
        $track = Track::select('id')->where('id', $id)->get()->count();
        if ($track > 0) {
            $comment = Comment::create([
                'tid' => $id,
                'uid' => auth()->user()->id,
                'message' => $request->comment
            ]);
            return $this->sendResponse($comment, 'added comment successfully');
        }
        $this->notFound();
    }
    public function addReport(Request $request, $id)
    {
        //Reason
        //0: Copyright infringement
        //1: Other
        //Type
        //1: Tracks
        //2: Comments
        $track = Track::select('id')->where('id', $id)->get()->count();
        if ($track > 0) {
            //Report Status
            if ($request->type == 1) {
                $status = Report::where('track', $id)->where('type', $request->type)->where('by', auth()->user()->id)->get();
            } else {
                $status = Report::select('state')->where('track', $request->comment_id)->where('type', $request->type)->get();
            }
            if (count($status) > 0) {
                if ($status[0]->state == 0) {
                    return $this->sendError($request->type == 1 ? 'This track has already been reported and it will be reviewed in the shortest time, thank you.' : 'This comment has already been reported and it will be reviewed in the shortest time, thank you.');
                } elseif ($status[0]->state == 1) {
                    if ($request->type == 1) {
                        if ($status[0]->by == auth()->users()->id) {
                            return $this->sendError('This track is marked as <strong>safe</strong> by an administrator, thank you for your feedback.');
                        }
                    } else {
                        return $this->sendError('This comment is marked as <strong>safe</strong> by an administrator, thank you for your feedback.');
                    }
                } else {
                    return $this->sendResponse($request->type == 1 ? 'The track has been removed, thank you for your feedback.' : 'The comment has been removed, thank you for your feedback.',null);
                }
            } else {
                if ($request->type == 1) {
                    $comment = Report::create([
                        'track' => $id,
                        'by' => auth()->user()->id,
                        'parent' => 0,
                        'reason' => $request->reason,
                        'type' => $request->type,
                        'content' => nl2br(htmlspecialchars($request->reason == 1 ? $request->description : $request->description . '\r\n\r\n[' . $request->signature . ']'))
                    ]);
                } else {
                    $comment = Report::create([
                        'track' => $request->comment_id,
                        //commentId
                        'by' => auth()->user()->id,
                        'parent' => $id,
                        'reason' => 0,
                        'type' => $request->type,
                        'content' => $request->description
                    ]);
                }
                return $this->sendResponse($comment, $request->type == 1 ? 'The track has been reported, thank you for your feedback.' : 'The comment has been reported, thank you for your feedback.');
            }
        }
        $this->notFound();
    }
    public function disLikes($id)
    {
        $track = Track::select('id')->where('id', $id)->get()->count();
        if ($track > 0) {
            // Verify the Like state
            $verify = $this->verifyLike($id);
            if ($verify) {
                $delete_like = Like::where('track', $id)->where('by', auth('sanctum')->user()->id)->delete();
                if ($delete_like) {
                    Track::where('id', $id)->decrement('likes', 1);
                }
                return $this->sendResponse(false, 'Dislike');
            } else {
                return $this->sendResponse(false, 'You\'ve already disliked this track.');
            }
        }
    }
    public function verifyLike($id)
    {
        $likes = Like::select('id')->where('track', $id)->where('by', auth('sanctum')->user()->id)->get()->count();
        return $likes ? 1 : 0;
    }
    public function checkLikes($id)
    {
        $status = $this->verifyLike($id);
        return $this->sendResponse($status ? true : false, '');
    }
    public function likesFromTracks($id)
    {
        $likes = Like::select('users.*')->leftjoin('users', 'likes.by', '=', 'users.id')->where('likes.track', $id)->orderBy('likes.id', 'desc')->paginate(config('settings.e_per_page'));
        if ($likes) {
            return UsersResource::collection($likes)->resource;
        }

        return $this->notFound();
    }
    public function loadComments($id)
    {
        $comments = Comment::with('users')->where('tid', $id)->paginate(config('settings.e_per_page'));
        if ($comments) {
            return CommentsResource::collection($comments)->resource;
        }
        return $this->notFound();
    }
    public function deleteComment($id)
    {
        $delete = Comment::where('id', $id)->where('uid', auth()->user()->id)->delete();
        if ($delete) {
            return $this->sendResponse(null, 'Delete comment success');
        }
        return $this->notFound();
    }
    public function editComment(Request $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->message = $request->comment;
            $comment->save();
            return $this->sendResponse($comment, 'update comment success');
        } catch (\Throwable $th) {
            return $this->notFound();
        }

    }
    public function notFound()
    {
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}
