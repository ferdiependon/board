<?php
class User extends AppModel
{
    public $username2, $password2;
    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'username2' => array(
            'exists' => array(
                'username_exists'
            ),
        ),
        'password' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'password2' => array(
            'match' => array(
                'password_match',
            ),
        ),
    );
        
    public function login()
    {
        $this->validation['password2']['match'][] = $this->password;
        
        if (!$this->validate()) {
            throw new ValidationException('Invalid login credentials!');
        }
                
        $db = DB::conn();
        $md5 = md5($this->password);
        $row = $db->row(
            "SELECT 1 FROM user WHERE username = ? AND password = ?",
            array($this->username, $md5)
        );
        
        if ($row) {
            $_SESSION['username'] = $this->username;
        }
    }
    
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
    }
    
    public function register()
    {
        $this->username2 = $this->username;
        $this->validation['password2']['match'][] = $this->password;
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('Invalid username or password!');
        }
        
        $md5 = md5($this->password);
        
        $db = DB::conn();
        $db->begin();            
        $db->query('INSERT INTO user SET username = ?, password = ?', array($this->username, $md5));
        $this->id = $db->lastInsertId();            
        $db->commit();
    }
}