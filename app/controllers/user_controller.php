<?php
class UserController extends AppController
{
    public $page;

    public function login()
    {
        $user = new User;
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $user->password2 = $user->password;

        try {
            $user->login();
        } catch (ValidationException $e) {
        }
        
        $this->set(get_defined_vars());
    }
    
    public function logout()
    {
        $user = new User;
        $user->logout();
    }
    
    public function register()
    {
        $user = new User;
        $page = Param::get('page_next', 'register');
        
        switch ($page) {
            case 'register' :
                break;
            case 'register_end' :
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->password2 = Param::get('password2');
                try {
                    $user->register();
                } catch (ValidationException $e) {
                    $page = 'register';
                }
                break;
            default :
                throw new NotFoundException("{$page} is not found");
                break;
        }
        
        $this->set(get_defined_vars());
        $this->render($page);
    }
}
