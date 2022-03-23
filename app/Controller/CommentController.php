<?php

namespace App\Controller;

use App\Config\Route;

class CommentController extends BaseController
{

    /**
     * Approve or reject a blog comment
     */
    #[Route('/admin/updateComment', POST)]
    public function updateComment()
    {
        $comment_id = ($_POST['comment_id']);
        if ($comment_id && is_numeric($comment_id) ) {
            $data = ['id' => trim($comment_id), 'is_approved' => trim($_POST['is_approved'])];
            $execResult = $this->commentModel->updateComment($data);

            if(checkExec($execResult)) {
                messageDisplay('Comment Updated');
            } else {
                messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
            }
            setTab(POST_ACTION);
            
            redirect('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    /**
     * Remove a blog comment
     */
    #[Route('/admin/removeComment', POST)]
    public function removeComment()
    {
        if ($_POST['comment_id'] && is_numeric($_POST['comment_id']) ) {
            $execResult = $this->commentModel->removeComment(intval($_POST['comment_id']));
           if(checkExec( $execResult)) {
               messageDisplay('Comment Removed');
           } else {
               messageDisplay('Failed');
           }
            setTab(POST_ACTION);
            redirect('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    /**
     * Add a blog comment
     */
    #[Route('/blog/addComment', POST)]
    public function addBlogComment()
    {
        if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }
        $execResult = $this->commentModel->addBlogComment($_POST);
        if (checkExec( $execResult)) {
            messageDisplay('Comment added and will be reviewed.');
        } else {
            messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
        }

        redirect('location: '.URLROOT.'blog/post?id=' . $postId);
    }

}