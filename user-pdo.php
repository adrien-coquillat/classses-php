<?php

class user
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $isconnected;
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {

        $msg = '';



        $sth = $this->db->prepare("SELECT id FROM utilisateurs WHERE login = :login");
        $sth->bindParam(":login", $login, PDO::PARAM_STR, 255);
        $sth->execute();
        $checklogin = $sth->rowCount();



        if ($checklogin == 0) {

            if (strlen($login) > 4) {

                $sth = $this->db->prepare("SELECT id FROM utilisateurs WHERE email = :email");
                $sth->bindParam(":email", $login, PDO::PARAM_STR, 255);
                $sth->execute();
                $checkmail = $sth->rowCount();



                if ($checkmail == 0) {
                    if (strlen($password) > 5) {
                        if ((strlen($firstname) > 1) || (strlen($lastname) > 1)) {
                            $sth = $this->db->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
                            $sth->execute();
                            $this->login = $login;
                            $this->password = $password;
                            $this->email = $email;
                            $this->firstname = $firstname;
                            $this->lastname = $lastname;
                            var_dump([$login, $password, $email, $firstname, $lastname]);
                            return [$login, $password, $email, $firstname, $lastname];
                        } else {
                            $msg = " le prenom ou le nom doivent contenir 2 caractères";
                            return $msg;
                        }
                    } else {
                        $msg = "le mot de pass doit contenir 6 caractères";
                        return $msg;
                    }
                } else {
                    $msg = "adresse mail déjà existante";
                    return $msg;
                }
            } else {
                $msg = " le login doit contenir 5 caractères";
                return $msg;
            }
        } else {
            $msg = "login non disponible";
            return $msg;
        }
    }

    public function connect($login, $password)
    {
        $login = trim(htmlspecialchars($login));
        $password = trim(htmlspecialchars($password));
        $msg = '';

        $sth = $this->db->prepare("SELECT id FROM utilisateurs WHERE login = '$login'");
        $sth->bindParam(":login", $login, PDO::PARAM_STR, 255);
        $sth->execute();
        $checklogin = $sth->rowCount();
        if ($checklogin != 0) {
            $query = $this->db->prepare("SELECT id FROM utilisateurs WHERE password = '$password'");
            $query->execute();
            $checkmdp = $query->rowCount();
            if ($checkmdp != 0) {
                $this->isconnected = true;
                $this->login = $login;
                $this->password = $password;
                $msg = 'connecté';
                return $msg;
            } else {
                $msg = 'mot de passe incorrect';
                return $msg;
            }
        } else {
            $msg = 'login incorrect';
            return $msg;
        }
    }

    public function getAllInfos()
    {
        return [$this->login, $this->password, $this->email, $this->firstname, $this->lastname];
    }

    public function disconnect()
    {
        // $this->isconnected = '';
        unset($this->isconnected);
        unset($this->login);
        unset($this->password);
        unset($this->email);
        unset($this->firstname);
        unset($this->lastname);
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $sth = $this->db = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        if (isset($this->isconnected) && $this->isconnected == true) {
            $sth = $this->db->prepare("UPDATE utilisateurs SET login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname' where login = '$this->login'");
            $sth->execute();
            $this->login = $login;
            $this->password = $password;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
        }
    }

    public function delete()
    {
        $sth = $this->db->prepare("DELETE FROM utilisateurs WHERE login = '$this->login'");
        $sth->execute();
        echo 'supprimé';
    }

    public function isConnected()
    {
        if (isset($this->login)) {
            return true;
        } else {
            return false;
        }
    }
    public function getlogin()
    {
        return [$this->login];
    }

    public function getemail()
    {
        return [$this->email];
    }

    public function getfirstname()
    {
        return [$this->firstname];
    }

    public function getlastname()
    {
        return [$this->lastname];
    }
    public function refresh()
    {
        $sth = $this->db = new PDO('mysql:host=localhost;dbname=classes', 'root', '');

        $sth = $this->db->prepare("SELECT * FROM utilisateurs WHERE id = '$this->id'");

        $resrefresh = $sth->rowCount();

        $this->login = $resrefresh['login'];
        $this->password = $resrefresh['password'];
        $this->email = $resrefresh['email'];
        $this->firstname = $resrefresh['firstname'];
        $this->lastname = $resrefresh['lastname'];
    }
}




$var = new user();
$ruben = new user();



// $ruben->connect("testee", "azerty");
// $ruben->update("adrien", "adrienboss", "adrien@rforj.fr", "adrien", "adrien");
// var_dump($var->getAllInfos());
// var_dump($ruben->getAllInfos());
