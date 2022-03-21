<?php

namespace App\Controller;

use App\View\View;
class CommentController extends BaseController
{

    public function updateComment()
    {
        $comment_id = ($_POST['comment_id']);
        if ($comment_id && is_numeric($comment_id) ) {
            $data = ['id' => trim($comment_id), 'is_approved' => trim($_POST['is_approved'])];
            $execResult = $this->commentModel->updateComment($data);
//            var_dump( $aa);
            if($this->checkExec($execResult)) {
                messageDisplay(message:'Comment updated');
            } else {
                messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
            }
            $_SESSION['tab'] = self::COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    public function removeComment()
    {
        if ($_POST['comment_id'] && is_numeric($_POST['comment_id']) ) {
            $execResult = $this->commentModel->removeComment(intval($_POST['comment_id']));
           if($this->checkExec( $execResult)) {
               messageDisplay('Comment removed');
           } else {
               messageDisplay(message: 'Failed');
           }
            $_SESSION['tab'] = self::COMMENT_ACTION;
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

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
            messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
        }

        $results = $this->postModel->getBlogPostById($postId);
//        var_dump($_SERVER);
        header('location: '.URLROOT.'blog/post?id=' . $postId);
//

//        return View::make('blog/details', array_merge($results, ['msg' => 'Comment added! Waiting for Admin Users to review.' , 'wowwwwwwwwwwwwwwwwwwwwww' => 'gasggggggggggggggggggg']));
    }

}