<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
    );
    
    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment!');
        }
        
        $db = DB::conn();
        $db->begin();
        
        $db->query('INSERT INTO thread SET title = ?, author = ?, last_post = NOW()', array($this->title, $comment->username));
        $this->id = $db->lastInsertId();
        
        $this->write($comment);
        $db->commit();
    }
    
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));
        
        return new self($row);
    }

    public static function getAll($items, $page)
    {
        $threads = array();
        $page = ($page-1)*$items;
        
        $db = DB::conn();
        $count = $db->value("SELECT COUNT(*) FROM thread");
        $pages = (int) ceil($count/$items);
        
        $rows = $db->rows("SELECT * FROM thread ORDER BY last_post DESC, id DESC LIMIT $items OFFSET $page");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        
        array_unshift($threads, $pages);
                
        return $threads;
    }
    
    public function getComments($items, $page)
    {
        $comments = array();
        $page = ($page-1)*$items;
        
        $db = DB::conn();
        $count = $db->value("SELECT COUNT(*) FROM thread");
        $pages = (int) ceil($count/$items);
        
        $rows = $db->rows(
            "SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC LIMIT $items OFFSET $page",
            array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        
        array_unshift($comments, $pages);
        
        return $comments;
    }
    
    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('Invalid comment!');
        }
    
        $db = DB::conn();
        $db->query(
            'INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()',
            array($this->id, $comment->username, $comment->body)
        );
        $db->query(
            'UPDATE thread SET comments = comments + 1, last_post = NOW() WHERE id = ?',
            array($this->id)
        );
    }
}