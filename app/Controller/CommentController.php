<?php

namespace App\Controller;

use App\View\View;

class CommentController extends BaseController
{

    public function updateComment(): View
    {
        $comment_id = ($_POST['comment_id']);
        if ($comment_id && is_numeric($comment_id) ) {
            $data = ['id' => trim($comment_id), 'is_approved' => trim($_POST['is_approved'])];
            $this->commentModel->updateComment($data);

            $_SESSION['tab'] = self::COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
            return $this->admin();
        } else {
            return $this->errorPage();
        }
    }

    public function removeComment(): View
    {
        if ($_POST['comment_id'] && is_numeric($_POST['comment_id']) ) {
           $this->commentModel->removeComment(intval($_POST['comment_id']));
            $_SESSION['tab'] = self::COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
            return $this->admin();
        } else {
            return $this->errorPage();
        }
    }

    public function addComment()
    {
        if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }

        $this->commentModel->addComment($_POST);

        $results = $this->postModel->getPostById($postId);

        header('location: '.URLROOT.'blog/post?id=' . $postId);
    }

}