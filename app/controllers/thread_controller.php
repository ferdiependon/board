<?php
class ThreadController extends AppController
{
    public $comments;
    public $items;
    public $page;
    public $pages;

    public function create()
    {
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');
        
        switch ($page) {
            case 'create' :
                break;
            case 'create_end' :
                $thread->title = Param::get('title');
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default :
                throw new NotFoundException("{$page} is not found");
                break;
        }
        
        $this->set(get_defined_vars());
        $this->render($page);
    }
    
    public function index()
    {
        $items = (isset($_SESSION['t_items'])) ? $_SESSION['t_items'] : 10;
        $items = Param::get('items', $items);
        $_SESSION['t_items'] = $items;
        $page = Param::get('page', 1);

        $threads = Thread::getAll($items, $page);
        $pages = array_shift($threads);

        $this->set(get_defined_vars());
    }
    
    public function view()
    {
        $items = (isset($_SESSION['c_items'])) ? $_SESSION['c_items'] : 5;
        $items = Param::get('items', $items);
        $_SESSION['c_items'] = $items;
        $page = Param::get('page', 1);

        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments($items, $page);
        $pages = array_shift($comments);
        
        $this->set(get_defined_vars());
    }
    
    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');
        
        switch ($page) {
            case 'write' :
                break;
            case 'write_end' :
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');
                try {
                    $thread->write($comment);
                } catch (ValidationException $e) {
                    $page = 'write';
                }
                break;
            default :
                throw new NotFoundException("{@page} is not found");
                break;
        }
        
        $this->set(get_defined_vars());
        $this->render($page);
    }
}
