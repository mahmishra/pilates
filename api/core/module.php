<?php

/**
 * This class is used to manage module
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
include_once 'database.php';

class Module {

    private $params = Array();
    private $result = Array();
    private $action = null;
    private $request;
    private $db;
    private $user;

    /**
     * Method used to init parameters
     * @param array $params parameters
     * @return void
     */
    public function init($params) {
        $this->params = $params;
    }

    /**
     * Method used process module
     * @return void
     */
    public function process() {
        if (($action = $this->getAction())) {
            $action->process();
        } else {
            $this->result = Ebizu::error(21, array($this->params[1]));
        }
    }

    /**
     * Method used clear resources
     */
    public function destroy() {
        if ($this->db) {
            $this->db = null;
        }
    }

    /**
     * Method used to get action
     * @return Object ation
     */
    public function getAction() {
        if (count($this->getParams()) > 1) {
            if (defined('EBIZU_MODULE_ACTION')) {
                try {
                    // create reference class
                    $class = new ReflectionClass(EBIZU_MODULE_ACTION);
                    // create action instance
                    $this->action = $class->newInstanceArgs();
                    // init action
                    $this->action->init($this);
                } catch (Exception $e) {
                    $this->result = Ebizu::error(999, array($e->getMessage()));
                }
            } else {
                $this->result = Ebizu::error(20, array($this->params[1]));
            }
        }
        return $this->action;
    }

    /**
     * Method to get params
     * @return array params
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Method used to get request
     * @return Object request
     */
    public function getRequest() {
        if (!$this->request) {
            try {
                $this->request = json_decode(Ebizu::getRequest());
            } catch (Exception $e) {
                $this->result = Ebizu::error(8, array($e->getMessage()));
            }
        }
        return $this->request;
    }

    /**
     * Method used to get customer id
     * @param String $company company ID
     * @return String customer ID
     */
    public function getCustomerId($company) {
        $db = $this->getDB();
        $st = $db->prepare('SELECT '
                . 'a.cus_id, '
                . 'a.cus_mem_id, '
                . 'a.cus_com_id '
                . 'FROM tbl_customer a '
                . 'WHERE '
                . 'a.cus_mem_id="' . $this->user->id . '" AND '
                . 'a.cus_com_id="' . $company . '"');
        $st->execute();
        $record = $st->fetch(PDO::FETCH_BOTH);
        if ($record['cus_id'] == '') {
            // if not exists, create it
            try {
                $db->beginTransaction();
                $st = $db->prepare('INSERT INTO tbl_customer SET '
                        . 'cus_mem_id="' . $this->user->id . '", '
                        . 'cus_com_id="' . $company . '", '
                        . 'cus_datetime=UNIX_TIMESTAMP()');
                $st->execute();
                $db->commit();
                return $db->lastInsertId();
            } catch (Exception $e) {
                $db->rollBack();
            }
        }
        return $record['cus_id'];
    }

    /**
     * Method used to get customer id
     * @param String $company company ID
     * @return String customer ID
     */
    public function getBusinessCustomerId($member) {
        $db = $this->getDB();
        $st = $db->prepare('SELECT '
                . 'a.cus_id, '
                . 'a.cus_mem_id, '
                . 'a.cus_com_id '
                . 'FROM tbl_customer a '
                . 'WHERE '
                . 'a.cus_mem_id="' . $member . '" AND '
                . 'a.cus_com_id="' . $this->user->id . '"');
        $st->execute();
        $record = $st->fetch(PDO::FETCH_BOTH);
        if ($record['cus_id'] == '') {
            // if not exists, create it
            try {
                $db->beginTransaction();
                $st = $db->prepare('INSERT INTO tbl_customer SET '
                        . 'cus_mem_id="' . $member . '", '
                        . 'cus_com_id="' . $this->user->id . '", '
                        . 'cus_datetime=UNIX_TIMESTAMP()');
                $st->execute();
                $db->commit();
                return $db->lastInsertId();
            } catch (Exception $e) {
                $db->rollBack();
            }
        }
        return $record['cus_id'];
    }

    /**
     * Method used to get data
     * @return Object data
     */
    public function getData() {
        if ($this->getRequest() && isset($this->request->d)) {
            return $this->data = $this->request->d;
        }
        return null;
    }

    /**
     * Method to get result
     * @return Object
     */
    public function getResult() {
        return (object) $this->result;
    }

    /**
     * Method used to get database connection
     * @return PDO pdo object
     */
    public function getDB() {
        if (!$this->db) {
            $this->db = DB::PDO();
        }
        return $this->db;
    }

    /**
     * Method used to get user in session
     * @return Object user
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Method used to get user App in session
     * @return Object userApp
     */
    public function getUserApp() {
        return $this->userApp;
    }

    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isAuthorized() {
        $token = $this->getRequest()->t;
        $db = $this->getDB();
        try {
            $db->beginTransaction();
            $st = $db->prepare('DELETE FROM tbl_session '
                    . 'WHERE ses_valid < UNIX_TIMESTAMP()');
            $st->execute();
            $st = $db->prepare('SELECT '
                    . 'ses_id, '
                    . 'ses_key, '
                    . 'ses_activity,'
                    . 'mem_screen_name, '
                    . 'mem_id, '
                    . 'mem_usr_id, '
                    . 'mem_screen_name, '
                    . 'mem_email, '
                    . 'mem_photo, '
                    . 'mem_gender '
                    . 'FROM tbl_session a '
                    . 'INNER JOIN tbl_member b ON a.ses_usr_id=b.mem_usr_id '
                    . 'INNER JOIN tbl_user c ON a.ses_usr_id=c.usr_id '
                    . 'WHERE ses_key=:token AND '
                    . 'ses_valid >= UNIX_TIMESTAMP()');
            $st->bindParam(':token', $token);
            $st->execute();
            if ($st->rowCount() == 0) {
                $this->result = Ebizu::error(998, array($token));
                return false;
            } else {
                $record = $st->fetch(PDO::FETCH_BOTH);
                $user = array();
                $user['id'] = $record['mem_id'];
                $user['user'] = $record['mem_usr_id'];
                $user['name'] = $record['mem_screen_name'];
                $user['email'] = $record['mem_email'];
                $user['gender'] = $record['mem_gender'];
                $user['avatar'] = Ebizu::CDN_USER . $record['mem_photo'];
                $this->user = (object) $user;
                $st = $db->prepare('UPDATE tbl_session SET '
                        . 'ses_activity=UNIX_TIMESTAMP() '
                        . 'WHERE ses_id=:session');
                $st->bindParam(':session', $record['ses_id']);
                $st->execute();
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
        return true;
    }

    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isBusinessAuthorized() {
        $token = $this->getRequest()->t;
        $db = $this->getDB();
        try {
            $db->beginTransaction();
            $st = $db->prepare('DELETE FROM tbl_session '
                    . 'WHERE ses_valid < UNIX_TIMESTAMP()');
            $st->execute();
            $st = $db->prepare('SELECT '
                    . 'ses_id, '
                    . 'ses_key, '
                    . 'ses_activity,'
                    . 'com_id, '
                    . 'com_usr_id, '
                    . 'com_name, '
                    . 'com_email '
                    . 'FROM tbl_session a '
                    . 'INNER JOIN tbl_company b ON a.ses_usr_id=b.com_usr_id '
                    . 'INNER JOIN tbl_user c ON a.ses_usr_id=c.usr_id '
                    . 'WHERE ses_key=:token AND '
                    . 'ses_valid >= UNIX_TIMESTAMP()');
            $st->bindParam(':token', $token);
            $st->execute();
            if ($st->rowCount() == 0) {
                $this->result = Ebizu::error(998, array($token));
                return false;
            } else {
                $record = $st->fetch(PDO::FETCH_BOTH);
                $user = array();
                $user['id'] = $record['com_id'];
                $user['user'] = $record['com_usr_id'];
                $user['name'] = $record['com_name'];
                $user['email'] = $record['com_email'];
                $this->user = (object) $user;
                $st = $db->prepare('UPDATE tbl_session SET '
                        . 'ses_activity=UNIX_TIMESTAMP() '
                        . 'WHERE ses_id=:session');
                $st->bindParam(':session', $record['ses_id']);
                $st->execute();
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
        return true;
    }

    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isTabletAuthorized() {
        $pin = $this->getRequest()->p;
        $db = $this->getDB();
        if ($this->isBusinessAuthorized()) {
            $st = $db->prepare('SELECT '
                    . 'a.usr_id, '
                    . 'a.usr_tablet_name, '
                    . 'a.usr_email '
                    . 'FROM tbl_user a '
                    . 'INNER JOIN tbl_company b ON a.usr_com_id=b.com_id '
                    . 'WHERE usr_com_id=:comid and usr_password=MD5('.$pin.')');
            $st->bindParam(':comid', $this->user->id);
            $st->execute();
            if ($st->rowCount() == 0) {
                $this->result = Ebizu::error(901, array());
                return false;
            } else {
                $record = $st->fetch(PDO::FETCH_BOTH);
                $userApp = array();
                $userApp['id'] = $record['com_id'];
                $userApp['user'] = $record['com_usr_id'];
                $userApp['name'] = $record['com_name'];
                $userApp['email'] = $record['com_email'];
                $this->userApp = (object) $userApp;
                return true;
            }
        }
        return false;
    }

    /**
     * Method used to set result
     * @param Array $result array result
     * @return void
     */
    public function setResult($result) {
        $this->result = $result;
    }

}

?>
