<?php
class User extends AppModel
{
    public $md5;
    public $password_reg;               // used for checking if passwords match
    public $row;
    public $username_reg;               // used for checking existence of username

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'password' => array(
            'length' => array(
                'validate_between', 1, 32,
            ),
        ),
        'password_reg' => array(        // separated because logging in performs this
            'match' => array(           // matching check on the password field
                'password_match',
            ),
        ),
    );

    public function login()
    {
        // manually add password as argument to match check
        $this->validation['password_reg']['match'][] = $this->password;

        if (!$this->validate()) {
            //throw new ValidationException('Invalid login credentials!');
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
        $_SESSION = array();    // removing this renders the log out page but still shows
        session_destroy();      // the user as logged in until the page refreshes once
    }
    
    public function register()
    {
        // manually add password as argument to match check
        $this->validation['password_reg']['match'][] = $this->password;
        $this->username_exists();
        if (!$this->validate() || $this->username_reg) {
            throw new ValidationException('Invalid registration info!');
        }
        
        $db = DB::conn();
        $md5 = md5($this->password);

        $db->query(
            'INSERT INTO user SET username = ?, password = ?',
            array($this->username, $md5)
        );
    }

    function username_exists()
    {
        $db = DB::conn();

        $row = $db->value(
            'SELECT 1 FROM user WHERE username = ?',
            array($this->username)
        );

        return $this->username_reg = (bool)$row;
    }
}
