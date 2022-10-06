<?php


namespace App\Controllers;


use App\Requests\CommentUserCreateRequest;
use App\Requests\UserUpdateRequest;
use App\Services\ArticleService;

class ArticleController extends BaseController
{

    protected ArticleService $articleService;

    public function __construct()
    {
        parent::__construct();
        $this->articleService = new ArticleService();
    }

    /**
     * @return void
     */
    public function home()
    {
        $response = [
            'article' => $this->articleService->getSampleArticle(1),
            'comments' => $this->articleService->getCommentsWithUsersSort(),
        ];

        $this->view('home.template', $response);
    }

    /**
     * @return void
     */
    public function about()
    {
        $response = [
            'title' => 'About page'
        ];

        $this->view('about.template', $response);
    }

    /**
     * @param array $request
     * @return string
     */
    public function storeComment(array $request): string
    {
        $validate = (new CommentUserCreateRequest($request))->validate();

        if (!$validate['status']) {
            return "Error validate: " . implode('', $validate['messages']);
        }

        $commentData = $validate['fields'];
        $insertedCommentData = $this->articleService->storeCommentData($commentData);

        return $this->articleService->getCommentView($insertedCommentData);
    }

    /**
     * @param array $request
     * @return string
     */
    public function sortComments(array $request): string
    {
        return $this->articleService->sortCommentsView($request);
    }


}