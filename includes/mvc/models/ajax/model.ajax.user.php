<?php
  class User_Ajax_Model {
    public function __construct() {

    }
    public function update_user_infos($username, $email, $password, $new_password){
        $pwdmd5 = md5($password);
        $npwdmd5 = md5($new_password);

        $sql = "UPDATE users SET ";
        $sql .= "email = '$email' ";

        if (isset($new_password) && !empty($new_password)){
            $sql .= ', ';
            $sql .= 'password = "'.$npwdmd5.'" ';
        }

        $sql .= "WHERE username='$username' and password='$pwdmd5'";

        $db = Db::getInstance();
        $qry = $db->prepare($sql);
        $qry->execute();

        if ($qry->rowCount() == 1){
            $message = array(
                    'message' => 'Les informations ont bien été modifiées.',
                    'success' => true,
            );
            return $message;
        }
        else {
            $message = array(
                    'message' => "Le mot de passe ne correspond pas ou il n'y avait rien a modifier.",
                    'code' => '418',
                    'success' => false,
            );
            return $message;
        }
    }

  }
?>