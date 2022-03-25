<?php

namespace App\Controller;

use App\Config\Route;
use App\View\View;

class PostController extends BaseController
{
    /**
     * Navigate to blog post listing page
     * @return View
     */
    #[Route('/blog', GET)]
    public function getBLogPostList() :View
    {
        $results = $this->postModel->getBLogPostList();
        return View::make('blog/index', $results);
    }

    /**
     * Navigate to an individual blog post viewing page
     * @return View
     */
    #[Route('/blog/post', GET)]
    public function getBlogPost() :View
    {
        if ($_GET['id']) {
            $postId = $_GET['id'];
        } else if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }

        $results = $this->postModel->getBlogPostById($postId);

        return View::make('blog/details', $results);
    }

    /**
     * Remove a post
     */
    #[Route('/admin/removePost', POST)]
    public function removePost()
    {
        $post_id = ($_POST['post_id']);

        if ($post_id && is_numeric($post_id) ) {
            setTab(POST_ACTION);
            $execResult = $this->postModel->removePost($post_id);
            if(checkExec($execResult)) {
                messageDisplay('Post Removed');
                // Remove the responding comments
                $this->commentModel->removeCommentByPostId($post_id);
            } else {
                messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
            }

            redirect('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    /**
     * Create a blog post
     */
    #[Route('/admin/createPost', POST)]
    public function createPost()
    {
        if (checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                setTab(POST_ACTION);
                $data = ['body' => trim($_POST['body']),
                    'title' => trim($_POST['title']),
                    'user_id' => trim($_POST['user_id'])];

                $execResult = $this->postModel->createPost($data);
                if(checkExec($execResult)) {
                    messageDisplay('Post Created');
                    redirect('location: '.URLROOT.'admin');
                } else {
                    messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
                    return View::make('admin/post/add');
                }
            } else {
                $userList = $this->userModel->getUserList();
                return View::make('admin/post/add', ['users' => $userList]);
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Navigate to the page for adding a post
     */
    #[Route('/admin/post/add', GET)]
    public function addPost(): View
    {
        if (checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                setTab(POST_ACTION);
                $userListRes = $this->userModel->getUserList();
                if (checkExec($userListRes)) {
                    return View::make('admin/post/add', ['users' => getExecInfo($userListRes)]);
                }
                return View::make('admin/post/add');
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Update a blog post
     */
    #[Route('/admin/updatePost', POST)]
    public function updatePost()
    {
        if (checkLogInStatus()) {

            if ($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                setTab(POST_ACTION);
                $data = [
                    'body' => trim($_POST['body']),
                    'title' => trim($_POST['title']),
                    'id' => trim($_POST['post_id']),
                    'user_id' => trim($_POST['user_id'])
                ];

                $execResult = $this->postModel->updatePost($data);
                if (checkExec($execResult)) {
                    messageDisplay('Post Updated');
                    redirect('location: ' . URLROOT . 'admin');

                } else {
                    messageDisplay('Failed. ' . getExecInfo($execResult), 'err_msg');
                    $params = ['err_msg' => getExecInfo($execResult)];
                    return View::make('admin/post/update', $params);
                }
            } else {

                return $this->errorPage();

            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Navigate to the page for editing a post
     * @return View
     */
    #[Route('/admin/post/edit', GET)]
    public function editPost(): View
    {
        if (checkLogInStatus()) {

            if ($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                $_SESSION['tab'] = POST_ACTION;
                $post_id = ($_GET['id']);
                if ($post_id && is_numeric($post_id)) {
                    $result = $this->postModel->getPostById($post_id);
                    $userListRes = $this->userModel->getUserList();
                    $userListRes = $this->userModel->getUserList();
                    if (checkExec($userListRes)) {
                        return View::make('admin/post/update', ["post" => $result, 'users' => getExecInfo($userListRes)]);
                    }
                    return View::make('admin/post/update');
                } else {
                    return $this->errorPage();
                }
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }
}