<?php
 
/**
 * Handles user interactions within the app
 *
 * PHP version 5
 *
 */
class ColoredListsUsers
{
    /**
     * The database object
     *
     * @var object
     */
    private $_db;
 
    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL)
    {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }
    
    /**
     * Checks and inserts a new account email into the database
     *
     * @return string    a message indicating the action status
     */
    public function createAccount()
    {
        $u = trim($_POST['e']);
        $v = sha1(time());
 
        $sql = "SELECT COUNT(Email) AS theCount
                FROM users
                WHERE Email=:email";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":email", $u, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row['theCount']!=0) {
                return "<h2> Error </h2>"
                    . "<p> Sorry, that email is already in use. "
                    . "Please try again. </p>";
            }
            $sendgrid = new SendGrid($_ENV['SG_KEY']);
            $mail = new SendGrid\Email();
            
            
            try {
                $sendgrid->send($this->sendVerificationEmail($u, $v, $mail));
            } catch(\SendGrid\Exception $e) {
                echo $e->getCode();
                foreach($e->getErrors() as $er) {
                    echo $er;
                }
                return "<h2> Error </h2>"
                    . "<p> There was an error sending your"
                    . " verification email. Please "
                    . "<a href=mailto:windmage57@msn.com>contact "
                    . "us</a> for support. We apologize for the "
                    . "inconvenience. </p>";
            }
        }
 
        $sql = "INSERT INTO users(Email, ver_code)
                VALUES(:email, :ver)";
        if($stmt = $this->_db->prepare($sql)) {
            $stmt->bindParam(":email", $u, PDO::PARAM_STR);
            $stmt->bindParam(":ver", $v, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
 
            $userID = $this->_db->lastInsertId();
            $url = dechex($userID);
            
            return "<h2> Success! </h2>"
                    . "<p> Your account was successfully "
                    . "created with the username <strong>$u</strong>."
                    . " Check your email!";
        } else {
            return "<h2> Error </h2><p> Couldn't insert the "
                    . "user information into the database. </p>";
        }
    }
    
    /**
     * Returns compiled email to be sent to the user with a link to verify their new account
     *
     * @param string $email   The user's email address
     * @param string $ver     The random verification code for the user
     * @param string $sendgm  SendGrid instance
     * @return $sendgm        Return compiled mail
     */
    private function sendVerificationEmail($email, $ver, $sendgm)
    {
        $e = sha1($email); // For verification purposes
        $sendgm
            ->addTo($email)
            ->setFrom('donotreply@woobs.herokuapp.com')
            ->setFromName('WolvesOfOld')
            ->setSubject('[WolvesOfOld] Please Verify Your Account')
            ->setText('You have a new account at WolvesOfOld Clan Page!
 
To get started, please activate your account, choose a username, and choose a
password by following the link below.
 
Activate your account: https://woobs.herokuapp.com/accountverify.php?v=%ver%&e=%e%
 
If you have any questions, please contact WindMage57@msn.com.
 
--
Thanks!
 
Rairaku
woobs.herokuapp.com')
            ->setSubstitutions(array(
                '%ver%' => array($ver), 
                '%e%' => array($e)
            ))
        ;
 
        return $sendgm;
    }
    
    /**
     * Checks credentials and verifies a user account
     *
     * @return array    an array containing a status code and status message
     */
    public function verifyAccount()
    {
        $sql = "SELECT Email, Username
                FROM users
                WHERE ver_code=:ver
                AND SHA1(Email)=:user
                AND verified=0";
 
        if($stmt = $this->_db->prepare($sql))
        {
            $stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR);
            $stmt->bindParam(':user', $_GET['e'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if(isset($row['Email']))
            {
                // Logs the user in if verification is successful
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['LoggedIn'] = 1;
            }
            else
            {
                return array(4, "<h2>Verification Error</h2>"
                    . "<p>This account has already been verified. "
                    . "Did you <a href=/password.php>forget "
                    . "your password?</a>");
            }
            $stmt->closeCursor();
 
            // No error message is required if verification is successful
            return array(0, NULL);
        }
        else
        {
            return array(2, "<h2>Error</h2>n<p>Database error.</p>");
        }
    }
    
    /**
     * Changes the user's username
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updateUsername()
    {
        if(isset($_POST['u']))
        {
            $sql = "UPDATE users
                    SET Username=:username
                    WHERE ver_code=:ver
                    LIMIT 1";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":username", $_POST['u'], PDO::PARAM_STR);
                $stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
 
                return TRUE;
            }
            catch(PDOException $e)
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Changes the user's password
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updatePassword()
    {
        if(isset($_POST['p'])
        && isset($_POST['r'])
        && $_POST['p']==$_POST['r'])
        {
            $sql = "UPDATE users
                    SET Password=MD5(:pass), verified=1
                    WHERE ver_code=:ver
                    LIMIT 1";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":pass", $_POST['p'], PDO::PARAM_STR);
                $stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
 
                return TRUE;
            }
            catch(PDOException $e)
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Checks credentials and logs in the user
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function accountLogin()
    {
        $sql = "SELECT Username, Email
                FROM users
                WHERE (Username=:user
                OR Email=:user)
                AND Password=MD5(:pass)
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':user', $_POST['u'], PDO::PARAM_STR);
            $stmt->bindParam(':pass', $_POST['p'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if($stmt->rowCount()==1)
            {
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['LoggedIn'] = 1;
                return TRUE;
            }
            else
            {
                return FALSE;
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
    
    /**
     * Retrieves the ID and verification code for a user
     *
     * @return mixed    an array of info or FALSE on failure
     */
    public function retrieveAccountInfo()
    {
        $sql = "SELECT UserID, ver_code
                FROM users
                WHERE Username=:user
                AND Email=:email";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':user', $_SESSION['Username'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $_SESSION['Email'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            $stmt->closeCursor();
            return array($row['UserID'], $row['ver_code']);
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
    
    /**
     * Changes a user's email address
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updateEmail()
    {
        $sql = "UPDATE users
                SET Email=:email
                WHERE UserID=:user
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':email', $_POST['e'], PDO::PARAM_STR);
            $stmt->bindParam(':user', $_POST['uid'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
 
            // Updates the session variable
            $_SESSION['Email'] = htmlentities($_POST['e'], ENT_QUOTES);
 
            return TRUE;
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
    
    /**
     * Deletes an account and all associated lists and items
     *
     * @return void
     */
    public function deleteAccount()
    {
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1)
        {
            // Delete list items
            $sql = "DELETE FROM list_items
                    WHERE ListID=(
                        SELECT ListID
                        FROM lists
                        WHERE UserID=:user
                        LIMIT 1
                    )";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['uid'], PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
 
            // Delete the user's list(s)
            $sql = "DELETE FROM lists
                    WHERE UserID=:user";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['uid'], PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
 
            // Delete the user
            $sql = "DELETE FROM users
                    WHERE UserID=:user
                    AND (Username=:username
                    OR Email=:email)";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['uid'], PDO::PARAM_INT);
                $stmt->bindParam(":username", $_SESSION['Username'], PDO::PARAM_STR);
                $stmt->bindParam(":email", $_SESSION['Email'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
 
            // Destroy the user's session and send to a confirmation page
            unset($_SESSION['LoggedIn'], $_SESSION['Username'], $_SESSION['Email']);
            header("Location: /gone.php");
            exit;
        }
        else
        {
            header("Location: /account.php?d=failed");
            exit;
        }
    }
    
    /**
     * Resets a user's status to unverified and sends them an email
     *
     * @return mixed    TRUE on success and a message on failure
     */
    public function resetPassword()
    {
        $sql = "UPDATE users
                SET verified=0
                WHERE Email=:email
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":email", $_POST['e'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        
        $sql = "SELECT ver_code
                FROM users
                WHERE Email=:email
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":email", $_POST['e'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            $v = $row["ver_code"];
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        
        $sendgrid = new SendGrid($_ENV['SG_KEY']);
        $mail = new SendGrid\Email();
            
            
        try {
            $sendgrid->send($this->sendResetEmail($_POST['e'], $v, $mail));
        } catch(\SendGrid\Exception $e) {
            echo $e->getCode();
            foreach($e->getErrors() as $er) {
                echo $er;
            }
            return "Sending the email failed!";
        }
       
        return TRUE;
    }
    
    /**
     * Sends a link to a user that lets them reset their password
     *
     * @param string $email    the user's email address
     * @param string $ver    the user's verification code
     * @return boolean        TRUE on success and FALSE on failure
     */
    private function sendResetEmail($email, $ver, $sendgm)
    {
        $e = sha1($email); // For verification purposes
        $sendgm
            ->addTo($email)
            ->setFrom('donotreply@woobs.herokuapp.com')
            ->setFromName('WolvesOfOld')
            ->setSubject('[WolvesOfOld] Request to Reset Your Password')
            ->setText('We just heard you forgot your password! Bummer! To get going again,
head over to the link below and choose a new password.
 
Follow this link to reset your password:
https://woobs.herokuapp.com/resetpassword.php?v=%ver%&e=%e%
 
If you have any questions, please contact WindMage57@msn.com.
 
--
Thanks!
 
Rairaku
woobs.herokuapp.com')
            ->setSubstitutions(array(
                '%ver%' => array($ver), 
                '%e%' => array($e)
            ))
        ;
 
        return $sendgm;
    }
}
 
 
?>