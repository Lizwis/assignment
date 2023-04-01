<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Comment\CommentRepositoryInterface;
use App\Services\ApiLogger;
use Illuminate\Http\Response;


class CommentController extends Controller
{
    private $commentRepository, $logger;

    public function __construct(CommentRepositoryInterface $commentRepository, ApiLogger $logger)
    {
        $this->commentRepository = $commentRepository;
        $this->logger = $logger;
    }

    public function show($commentId)
    {
        $comment = $this->commentRepository->findCommentByid($commentId);

        $this->saveLogs($comment);


        return $comment->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function delete($commentId)
    {
        $comment = $this->commentRepository->deleteComment($commentId);

        $this->saveLogs($comment);

        return response()->json($comment, Response::HTTP_CREATED);
    }


    private function saveLogs($data)
    {
        $response = new Response([$data]);

        $responseContent = $response->getContent();

        $this->logger->log(request()->url(), $responseContent);
    }
}
