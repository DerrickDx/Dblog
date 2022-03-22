<?php

namespace App\Controller;

use App\Config\Route;
use App\View\View;
class CommentController extends BaseController
{

    #[Route('/admin/updateComment', POST)]
    public function updateComment()
    {
        $comment_id = ($_POST['comment_id']);
        if ($comment_id && is_numeric($comment_id) ) {
            $data = ['id' => trim($comment_id), 'is_approved' => trim($_POST['is_approved'])];
            $execResult = $this->commentModel->updateComment($data);
//            var_dump( $aa);
            if($this->checkExec($execResult)) {
                messageDisplay('Comment Updated');
            } else {
                messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
            }
            $_SESSION['tab'] = COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    #[Route('/admin/removeComment', POST)]
    public function removeComment()
    {
        if ($_POST['comment_id'] && is_numeric($_POST['comment_id']) ) {
            $execResult = $this->commentModel->removeComment(intval($_POST['comment_id']));
           if($this->checkExec( $execResult)) {
               messageDisplay('Comment Removed');
           } else {
               messageDisplay('Failed');
           }
            $_SESSION['tab'] = COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    #[Route('/blog/addComment', POST)]
    public function addBlogComment()
    {
        if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }
        $execResult = $this->commentModel->addBlogComment($_POST);
        if ($this->checkExec( $execResult)) {
            messageDisplay('Comment added and will be reviewed.');
        } else {
            messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
        }

        header('location: '.URLROOT.'blog/post?id=' . $postId);
    }

}