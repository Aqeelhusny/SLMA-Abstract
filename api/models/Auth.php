<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/send_mail.php';
class Auth
{

    private $conn;
    private $table = 'user';
    public $id;
    public $title;
    public $first_name;
    public $last_name;
    public $qualification;
    public $phone;
    public $whatsapp_no;
    public $landline_no;
    public $designation;
    public $affiliation;
    public $home_address;
    public $office_address;
    public $password;
    public $email;
    public $created_at;
    public $message;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getUserById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->qualification = $row['qualification'];
            $this->whatsapp_no = $row['whatsapp_no'];
            $this->landline_no = $row['landline_no'];
            $this->designation = $row['designation'];
            $this->affiliation = $row['affiliation'];
            $this->home_address = $row['home_address'];
            $this->office_address = $row['office_address'];
            $this->email = $row['email'];
            $this->created_at = $row['created_at'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->phone = $row['phone'];
            $this->created_at = $row['created_at'];
            $stmt->close();
            return true;
        }
        $stmt->close();
        $this->message = array('message' => 'user not found', 'status' => 404);
        return false;
    }

    public function login()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            if (password_verify(trim($this->password), $row['password'])) {
                $this->id = $row['id'];
                $this->title = $row['title'];
                $this->qualification = $row['qualification'];
                $this->whatsapp_no = $row['whatsapp_no'];
                $this->landline_no = $row['landline_no'];
                $this->designation = $row['designation'];
                $this->affiliation = $row['affiliation'];
                $this->home_address = $row['home_address'];
                $this->office_address = $row['office_address'];
                $this->email = $row['email'];
                $this->created_at = $row['created_at'];
                $this->first_name = $row['first_name'];
                $this->last_name = $row['last_name'];
                $this->phone = $row['phone'];
                $this->message = array('message' => 'Login success', 'status' => 200);
                return true;
            } else {
                $this->message = array('message' => 'invalid password', 'status' => 401);
                return false;
            }
        }
        $stmt->close();
        $this->message = array('message' => 'User not found', 'status' => 404);
        return false;
    }

    public function register()
    {
        if ($this->isUserExist()) {
            return false;
        }
        $query = 'INSERT INTO ' . $this->table . ' (title,first_name, last_name,qualification,phone,whatsapp_no,
        landline_no,designation,affiliation,home_address,office_address, password, email) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssssssssssss',
            $this->title,
            $this->first_name,
            $this->last_name,
            $this->qualification,
            $this->phone,
            $this->whatsapp_no,
            $this->landline_no,
            $this->designation,
            $this->affiliation,
            $this->home_address,
            $this->office_address,
            $this->password,
            $this->email
        );
        if ($stmt->execute()) {
            $this->id = mysqli_insert_id($this->conn);
            $this->message = array('message' => 'Registration success !', 'status' => 201);
            return true;
        } else {
            $this->message = array('message' => 'Registration failed !', 'status' => 500);
            return false;
        }
    }

    public function isUserExist()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $this->message = array('message' => 'User already exists', 'status' => 409);
            return true;
        }
        return false;
    }

    public function sendVerificationCode($email)
    {
        $verification_code = mt_rand(100000, 999999);
        $sendMail = new EmailService();
        $sendMail::sendEmail(
            "SLMA Verification Code",
            "Your verification code is " . $verification_code,
            array("emails" => array($email))
        );
        return $verification_code;
    }
}
