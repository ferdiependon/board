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
        
        $db->query('INSERT INTO thread SET title = ?, author = ?, created = NOW()', array($this->title, $comment->username));
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

    public static function getAll()
    {
        $threads = array();
        
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM thread');
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        
        return $threads;
    }
    
    public function getComments()
    {
        $comments = array();
        
        $db = DB::conn();
        $rows = $db->rows(
            'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC',
            array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        
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
    }
}