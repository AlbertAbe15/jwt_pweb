<?php
    class Api extends Rest {
        public $dbConn;

        public function __construct() {
            parent::__construct();
        }

        public function buatToken() {
            $email = $this->validateParameter(
                'email', $this->param['email'], STRING);
            $pass = $this->validateParameter(
                'pass', $this->param['password'], STRING);

            try {
                $stmt = $this->dbConn->
                    prepare("SELECT * FROM users WHERE user_email = :email AND user_pass = :pass");
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if(!is_array($user)) {
                    $this->returnResponse(INVALID_USER_PASS, 
                    "Email atau Password salah");
                }
                if($user['is_active']==0) {
                    $this->returnResponse(USER_NOT_ACTIVE,
                    "User tidak aktif");
                }

                $payload = [
                    'iat' => time(),
                    'iss' => 'localhost',
                    'exp' => time() + (15*60),
                    'userId' => $user['user_id'],
                    'isAdmin'=> $user['is_admin']
                ];

                $token = JWT::encode($payload, SECRET_KEY);
                
                $data = ['token' => $token];
                $this->returnResponse(SUCCESS_RESPONSE, $data);
            } catch (Exception $e) {
                $this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
            }
        }

        public function tambahUser() {
            $name = $this->validateParameter(
                'name', $this->param['nama'], STRING);
            $email = $this->validateParameter(
                'email', $this->param['email'], STRING);
            $pass = $this->validateParameter(
                'pass', $this->param['password'], STRING);
            $phone = $this->validateParameter(
                'phone', $this->param['no_telepon'], INTEGER, false);
            $isActive = $this->validateParameter(
                'isActive', $this->param['aktif'], BOOLEAN, false);
            $isAdmin = $this->validateParameter(
                'isAdmin', $this->param['admin'], BOOLEAN, false);

            $newUser = new User;
            $newUser->setName($name);
            $newUser->setEmail($email);
            $newUser->setPass($pass);
            $newUser->setPhone($phone);
            $newUser->setIsActive($isActive);
            $newUser->setIsAdmin($isAdmin);
            $newUser->setCreatedBy($this->userId);
            $newUser->setCreatedOn(date('y-m-d'));

            if ($this->isAdmin == 1) {
                if (!$newUser->insert()) {
                    $message = 'Gagal memasukkan data';
                } else {
                    $message = 'Berhasil memasukkan data';
                }
            } else {
                $message = 'Tidak memiliki kekuasaan untuk memasukkan data';
            }

            $this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        public function lihatDetail() {
            $userId = $this->validateParameter(
                'userId', $this->param['id'], INTEGER);

            $newUser = new User;
            $newUser->setId($userId);

            if ($this->isAdmin == 0 && $this->userId != $userId) {
                $message = 'Tidak memiliki kekuasaan untuk melihat data';
            } else {
                $user = $newUser->getUserDetailsById();

                if (!is_array($user)) {
                    $message = 'Data tidak ditemukan';
                }

                $response['userId']         = $user['user_id'];
                $response['Name']           = $user['user_name'];
                $response['email']          = $user['user_email'];
                $response['pass']           = $user['user_pass'];
                $response['phone']          = $user['user_phone'];
                $response['isActive']       = $user['is_active'];
                $response['isAdmin']        = $user['is_admin'];
                $response['createdBy']      = $user['created_user'];
                $response['lasstUpdatedBy'] = $user['updated_user'];
                
                $message = $response;
            }

            $this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        public function lihatSemuaUser() {
            $newUser = new User;
            if ($this->isAdmin == 0) {
                $message = 'Tidak memiliki kekuasaan untuk memasukkan data';
            } else {
                $user = $newUser->getAllUser();

                if (!is_array($user)) {
                    $message = 'User tidak ditemukan';
                } else {
                    $message = $user;
                }

            }

            $this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        public function updateUser() {
            $userId = $this->validateParameter(
                'userId', $this->param['id'], INTEGER);
            $name = $this->validateParameter(
                'name', $this->param['nama'], STRING);
            $pass = $this->validateParameter(
                'pass', $this->param['password'], STRING, false);
            $phone = $this->validateParameter(
                'phone', $this->param['no_telepon'], INTEGER, false);

            $newUser = new User;
            $newUser->setId($userId);
            $newUser->setName($name);
            $newUser->setPass($pass);
            $newUser->setPhone($phone);
            $newUser->setUpdatedBy($this->userId);
            $newUser->setUpdatedOn(date('y-m-d'));

            
            if ($this->isAdmin == 0 && $this->userId != $userId) {
                $message = 'Tidak memiliki kekuasaan untuk memasukkan data';
            } else {
                if (!$newUser->update()) {
                    $message = 'Gagal mengubah';
                } else {
                    $message = 'Berhasil diubah';
                }
            }

            $this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        public function hapusUser() {
            $userId = $this->validateParameter(
                'userId', $this->param['id'], INTEGER);

            $newUser = new User;
            $newUser->setId($userId);

            if ($this->isAdmin == 1) {
                if (!$newUser->delete()) {
                    $message = 'Gagal menghapus';
                } else {
                    $message = 'Berhasil Dihapus';
                }
            } else {
                $message = 'Tidak memiliki kekuasaan untuk memasukkan data';
            }

            $this->returnResponse(SUCCESS_RESPONSE, $message);
            
        }
    }
?>