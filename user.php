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

    public function register($login, $password, $email, $firstname, $lastname)
    {

        $db = mysqli_connect('localhost', 'root', '', 'classes');
        $login = mysqli_real_escape_string($db, trim(htmlspecialchars($login)));
        $email = mysqli_real_escape_string($db, trim(htmlspecialchars($email)));
        $password = mysqli_real_escape_string($db, trim(htmlspecialchars($password)));
        $firstname = mysqli_real_escape_string($db, trim(htmlspecialchars($firstname)));
        $lastname = mysqli_real_escape_string($db, trim(htmlspecialchars($lastname)));
        $msg = '';



        $query = mysqli_query($db, "SELECT id FROM utilisateurs WHERE login = '$login'");
        $all_result = mysqli_fetch_all($query);
        $checklogin = count($all_result);

        if ($checklogin == 0) {

            if (strlen($login) > 4) {

                $query = mysqli_query($db, "SELECT id FROM utilisateurs WHERE email = '$email'");
                $all_result = mysqli_fetch_all($query);
                $checkmail = count($all_result);

                if ($checkmail == 0) {
                    if (strlen($password) > 5) {
                        if ((strlen($firstname) > 1) || (strlen($lastname) > 1)) {
                            $query = mysqli_query($db, "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
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
        $db = mysqli_connect('localhost', 'root', '', 'classes');
        $login = mysqli_real_escape_string($db, trim(htmlspecialchars($login)));
        $password = mysqli_real_escape_string($db, trim(htmlspecialchars($password)));
        $msg = '';

        $query = mysqli_query($db, "SELECT id FROM utilisateurs WHERE login = '$login'");
        $all_result = mysqli_fetch_all($query);
        $checklogin = count($all_result);
        if ($checklogin == 1) {
            $query = mysqli_query($db, "SELECT id FROM utilisateurs WHERE password = '$password'");
            $all_result = mysqli_fetch_all($query);
            $checkmdp = count($all_result);
            if ($checkmdp == 1) {
                $this->isconnected = true;
                $this->login = $login;
                $this->password = $password;
                $msg = 'connecté';
                echo $msg;
                return $msg;
            } else {
                $msg = 'mot de passe incorrect';
                echo $msg;
                return $msg;
            }
        } else {
            $msg = 'login incorrect';
            echo $msg;
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
        $db = mysqli_connect('localhost', 'root', '', 'classes');
        if (isset($this->isconnected) && $this->isconnected == true) {
            $query = mysqli_query($db, "UPDATE utilisateurs SET login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname' where login = '$this->login'");
            $this->login = $login;
            $this->password = $password;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
        }
    }

    public function delete()
    {
        $db = mysqli_connect('localhost', 'root', '', 'classes');

        $delete = mysqli_query($db, "DELETE FROM utilisateurs WHERE login = '$this->login'");
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
        $db = mysqli_connect('localhost', 'root', '', 'classes');

        $refresh = mysqli_query($db, "SELECT * FROM utilisateurs WHERE id = '$this->id'");

        $resrefresh = mysqli_fetch_assoc($refresh);

        $this->login = $resrefresh['login'];
        $this->password = $resrefresh['password'];
        $this->email = $resrefresh['email'];
        $this->firstname = $resrefresh['firstname'];
        $this->lastname = $resrefresh['lastname'];
    }
}




$var = new user();
$ruben = new user();



$ruben->connect("testee", "azerty");
$ruben->update("adrien", "adrienboss", "adrien@rforj.fr", "adrien", "adrien");
var_dump($var->getAllInfos());
var_dump($ruben->getAllInfos());
