<?php
class User extends AppModel
{
    public $md5;
    public $password2;          // used for checking if passwords match
    public $row;
    public $username2;          // used for checking existence of username

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'username2' => array(   // separated because using username performs
            'exists' => array(  // this check when logging in
                'username_exists'
            ),
        ),
        'password' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'password2' => array(   // separated because logging in performs this
            'match' => array(   // matching check on the password field
                'password_match',
            ),
        ),
    );
        
    public function login()
    {
        // manually add password as argument to match check
        $this->validation['password2']['match'][] = $this->password;

        if (!$this->validate()) {
            throw new ValidationException('Invalid login credentials!');
        }
                
        $db = DB::conn();
        $md5 = md5($this->password);
        $row = $db->row(
            'SELECT 1 FROM user WHERE username = ? AND password = ?',
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
        // temporarily copy username to check if existing
        $this->username2 = $this->username;
        // manually add password as argument to match check
        $this->validation['password2']['match'][] = $this->password;
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('Invalid username or password!');
        }
        
        $db = DB::conn();
        $md5 = md5($this->password);
        $db->begin();

        $db->query(
            'INSERT INTO user SET username = ?, password = ?',
            array($this->username, $md5)
        );

        $db->commit();
    }
}
