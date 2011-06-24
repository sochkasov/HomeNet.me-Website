<?php

/**
 * Description of Manager
 *
 * @author mdoll
 */
class Core_Model_User_Manager extends Core_Model_Auth_Interface {
    
    const ERROR_BANNED = 2;
    const ERROR_NOT_ACTIVATED = 1;
    
    private $_user = null;
    private $_service;
    
    private $_authClass = 'Core_Model_Auth_Internal';
        
    public function __construct(Core_Model_User_Interface $user = null){
        $this->_user = $user;
        $this->_service = new Core_Model_User_Service();
    }
    
    public function setAuthClass($class){
        
        if(!class_exists($class)){
            throw new InvalidArgumentException('Class "'.$class.'" does not exist');      
        }
        
        $this->_authClass = $class;
    }
    
   public function login(array $credentials) {
       
       if(!is_null($this->_user)){
            throw new Exception("User already loaded");
        }
       
       /* @var $auth Core_Model_Auth_Interface */
        $auth = new $this->_authClass(); 
       $_SESSION['Core_Auth']['class'] = $this->_authClass;
       try{
        $userId = $auth->login($credentials); //@throws NotFoundException, Exception
       } catch (RequiresFurtherActionException $e){
           $_SESSION['Core_Auth']['credentials'] = $credentials;
           throw new RequiresFurtherActionException();
       }
       
        
        $this->_user = $this->_service->getObjectById($userId);

        
    
        if($this->_user->status == -1){
             $this->logout();
            throw new CMS_Exception("Account Not Activated", self::ERROR_NOT_ACTIVATED);
        } elseif($this->_user->status < -1){
            $this->logout();
            throw new CMS_Exception("User Banned", self::ERROR_BANNED);
        }

        
        $_SESSION['User'] = $this->_user->toArray();

    }

    public function logout() {
//try the same auth adapter used to login with, if not fall back to the default
        //facebook, twitter like to be logged out of too
        if(!empty($_SESSION['Core_Auth']['class'])){
            $auth = new $_SESSION['Core_Auth']['class']();
            $auth->logout();
        } else {
            //Zend_Session::destroy(true);

                $authAdapter = Zend_Auth::getInstance();
                $authAdapter->clearIdentity();
        }
    }

    /**
     * @param Array $values User Info
     * @return boolean
     */
    public function register($values = null) {
        
        if(!is_null($this->_user)){
            throw new Zend_Exception("User Already Loaded");
        }   
   
        $user = $this->_service->create($values); //throws exception if username exsists

        $auth = new Core_Model_Auth_Internal();
        $auth->add(array('id'=>$this->id, 'username'=>$this->username, 'password'=>$values['password']));
        
        //
        if(!empty($_SESSION['Core_Auth']['credentials'])){
            $auth = new $_SESSION['Core_Auth']['class']();
            $auth->add($_SESSION['Core_Auth']['credentials']);
        }

        $this->sendActivationEmail();
    }
    /**
     * @param string $oldpassword
     * @param string $newpassword
     * @return boolean
     */
    public function changePassword($oldpassword, $newpassword) {

//        if(is_null($this->_user)){
//            throw new Zend_Exception("User Not Loaded");
//        }
//        
//        $auth = new Core_Model_AuthInternal_Service();
//   
//     
//
//        if($this->password !== $this->hashPassword($oldpassword)){
//            throw new CMS_Exception("Old password doesn't match");
//        }
//
//        $this->password = $this->hashPassword($newpassword);
//        $this->save();
    }

    /**
     * @param string $key
     * @throw CMS_Exception
     */
    public function sendActivationEmail() {

        if (!$this->isConnected() || empty($this->id)) {
            throw new Zend_Exception("User Not Loaded");
        }

        if ($this->status > 0) {
            // throw new CMS_Exception("User Already Activated");
        }

        $key = uniqid('', true);

        $this->setSetting('activationKey', $key);
        $this->save();

        //send email
        $mail = new CMS_HtmlEmail();
        $mail->setSubject('Activate your HomeNet.me Account');
        $mail->addTo($this->email, $this->name);

        $mail->setViewParam('id', $this->id);
        $mail->setViewParam('name', $this->name);
        $mail->setViewParam('email', $this->email);
        $mail->setViewParam('username', $this->username);

        $url = Zend_Layout::getMvcInstance()->getView()->url(array('user' => $this->id, 'action'=>'activate', 'key' => $key), 'core-user');

        $mail->setViewParam('activationUrl', $url);

        $mail->sendHtmlTemplate('activate.phtml');



    }


    /**
     * @param string $key
     * @throw CMS_Exception
     */
    public function activate($key) {

        if(empty($this->id)){
            throw new CMS_Exception("User Not Loaded");
        }

        if($this->status > 0){
            throw new CMS_Exception("User Already Activated");
        }

        $userkey = $this->getSetting('activationKey');

        if($userkey === $key){
            $this->status = 1;
            $this->save();
            return;
        }

        throw new CMS_Exception("Invalid Activation Key");
    }
}