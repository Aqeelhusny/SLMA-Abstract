<?php

class AuthController
{
    private $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }


    public function login(string $method): void
    {
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->auth->email = $data->email;
            $this->auth->password = $data->password;
            if ($this->auth->login()) {
                echo json_encode(array(
                    'response' => $this->auth->message,
                    'user' => array(
                        'id' => $this->auth->id,
                        'email' => $this->auth->email,
                        'first_name' => $this->auth->first_name,
                        'last_name' => $this->auth->last_name,
                        'phone' => $this->auth->phone,
                        'designation' => $this->auth->designation,
                        'affiliation' => $this->auth->affiliation,
                        'home_address' => $this->auth->home_address,
                        'office_address' => $this->auth->office_address,
                        'qualification' => $this->auth->qualification,
                        'whatsapp_no' => $this->auth->whatsapp_no,
                        'landline_no' => $this->auth->landline_no,
                        'title' => $this->auth->title,
                        'created_at' => $this->auth->created_at
                    )
                ));
            } else {
                http_response_code($this->auth->message['status']);
                echo json_encode(array("response" => $this->auth->message));
            }
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'Page not found'));
        }
    }

    public function register(string $method): void
    {
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->auth->email = $data->email;
            $this->auth->password = password_hash($data->password, PASSWORD_DEFAULT);;
            $this->auth->first_name = $data->first_name;
            $this->auth->last_name = $data->last_name;
            $this->auth->phone = $data->phone;
            $this->auth->designation = $data->designation;
            $this->auth->qualification = $data->qualification;
            $this->auth->affiliation = $data->affiliation;
            $this->auth->home_address = $data->home_address;
            $this->auth->office_address = $data->office_address;
            $this->auth->whatsapp_no = $data->whatsapp_no;
            $this->auth->landline_no = $data->landline_no;
            $this->auth->title = $data->title;

            if ($this->auth->register()) {
                echo json_encode(array(
                    'response' => $this->auth->message,
                    'user' => array(
                        'id' => $this->auth->id,
                        'email' => $this->auth->email,
                        'first_name' => $this->auth->first_name,
                        'last_name' => $this->auth->last_name,
                        'phone' => $this->auth->phone,
                        'designation' => $this->auth->designation,
                        'affiliation' => $this->auth->affiliation,
                        'home_address' => $this->auth->home_address,
                        'office_address' => $this->auth->office_address,
                        'qualification' => $this->auth->qualification,
                        'whatsapp_no' => $this->auth->whatsapp_no,
                        'landline_no' => $this->auth->landline_no,
                        'title' => $this->auth->title,
                        'created_at' => $this->auth->created_at
                    )
                ));
            } else {
                http_response_code($this->auth->message['status']);
                echo json_encode(array("response" => $this->auth->message));
            }
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'Page not found'));
        }
    }

    public function sendVerificationEmail(string $method)
    {
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            if (!isset($data->email))
                echo json_encode(array('message' => 'Email is required'));
            $code = $this->auth->sendVerificationCode($data->email);
            if ($code != null) {
                echo json_encode(array(
                    'verification_code' => $code,
                    'message' => 'verification code sent to your email',
                ), JSON_PRETTY_PRINT);
            }
        }
    }
}
