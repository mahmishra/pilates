<?php

/**
 * This class is contain common functions
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
include_once 'error.php';
include_once 'aws.phar';
include_once 'facebook/facebook.php';

date_default_timezone_set("Asia/Singapore");

use Aws\Ses\SesClient;

class Ebizu {

    const CDN = 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/member/';
    const CDN_BUSINESS = 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/business/';
    const CDN_CATEGORIES_32 = 'https://d1307f5mo71yg9.cloudfront.net/images/categories/32/';
    const CDN_CATEGORIES_40 = 'https://d1307f5mo71yg9.cloudfront.net/images/categories/40/';
    const CDN_CATEGORIES_46 = 'https://d1307f5mo71yg9.cloudfront.net/images/categories/46/';
    const CDN_MODULES = 'https://d1307f5mo71yg9.cloudfront.net/images/tablet/';
    const CDN_USER = 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/member/';
//    const CDN = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/media/web/member/';
//    const CDN_BUSINESS = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/media/web/business/';
//    const CDN_CATEGORIES_32 = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/categories/32/';
//    const CDN_CATEGORIES_40 = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/categories/40/';
//    const CDN_CATEGORIES_46 = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/categories/46/';
//    const CDN_MODULES = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/tablet/';
//    const CDN_USER = 'https://s3-ap-southeast-1.amazonaws.com/ebizu-production/images/media/web/member/';

    const AWS_KEY = 'AKIAJ2UQQOLWLMFWSGDQ';
    const AWS_ACCES_KEY = '2P3LY8lId1w9H1ShfmQK8x22J6K1pY5rXoDJpMow';
    const AWS_BUCKET = 'ebizu-production';
    const AWS_SES_REGION = 'us-east-1';
    const EMAIL_SENDER = '? via Manis <noreply@getmanis.com>';
    const INVITE_LINK = 'http://getmanis.com/?';
    const INVITE_PARAM = 'id=?&action=?';
    const DISTANCE = 5;
    const PAGE_SIZE = 20;

    static $SES;
    static $FB;
    static $INVITE;

    /**
     * Method used to log activity
     * @param type $db db
     * @param type $params, fields
     */
    public static function activity($db, $user, $type, $params) {
        $fields = array();
        for ($i = 0; $i < count($params); $i++) {
            $fields[] = 'col' . ($i + 1) . '="' . $params[$i] . '"';
        }
        $st = $db->prepare('INSERT INTO tbl_activity SET '
                . 'acv_usr_id=:acv_usr_id, '
                . 'acv_act_id=:acv_act_id, '
                . 'acv_datetime=UNIX_TIMESTAMP(), '
                . implode(', ', $fields));
        $st->bindParam(':acv_usr_id', $user);
        $st->bindParam(':acv_act_id', $type);
        $st->execute();
    }

    /**
     * Method used to decode text
     * @param String $text encoded text
     * @return String plain text
     */
    public static function decode($text) {
        //return mb_convert_encoding(html_entity_decode($text), "UTF-8");
        return mb_convert_encoding($text, "UTF-8");
    }

    /**
     * Method used to get distance info
     * @param Number $distance distance
     * @return String distance in meter or kilometer
     */
    public static function distanceInfo($distance) {
        return $distance < 1 ? ($distance * 1000) . ' m' : $distance . ' km';
    }

    /**
     * Method used to raise error
     * @param Object $module module
     * @param Integer $code error code
     * @param Array $params array of parameters
     * @return Object error
     */
    public static function error($code, $params) {
        $result = Array();
        $error = Ebizu::getError($code);
        $result['e']['c'] = $error['code'];
        $result['e']['m'] = Ebizu::subtitute($error['description'], $params);
        return (object) $result;
    }

    /**
     * Method used to generate facebook configuration
     * @return String facebook configuration
     */
    public static function facebookConfig() {
        return array(
            'appId' => '1429632487248796',
            'secret' => '3295c643d97e95149e99d6e843867f63',
            'allowSignedRequest' => false
        );
    }

    /**
     * Method used to generate invitation unique id
     * @param type $db database connection
     */
    public static function generateInviteUniqueId($db) {
        $id = '';
        while (true) {
            $id = md5('' . time() . rand());
            $st = $db->prepare('SELECT ind_id, ind_unique_id '
                    . 'FROM tbl_invite_detail a '
                    . 'WHERE a.ind_unique_id="' . $id . '"');
            $st->execute();
            if ($st->rowCount() == 0) {
                break;
            }
        }
        return $id;
    }

    /**
     * Method used to get error
     * @param Integer $code error code
     * @return Array error
     */
    public static function getError($code) {
        global $EBIZU_ERROR;
        for ($i = 0; $i < count($EBIZU_ERROR); $i++) {
            if ($EBIZU_ERROR[$i]['code'] == $code) {
                return $EBIZU_ERROR[$i];
            }
        }
        return Array();
    }

    /**
     * Method used to parse first name
     * @param String $name full name
     * @return String first name
     */
    public static function getFirstName($name) {
        $x = explode(' ', $name);
        unset($x[count($x) - 1]);
        return implode(' ', $x);
    }

    public static function getInviteHtml() {
        if (!Ebizu::$INVITE) {
            Ebizu::$INVITE = file_get_contents('../ep/invite.html');
        }
        return Ebizu::$INVITE;
    }

    /**
     * Method used to get remote ip address
     * @return String remote ip address
     */
    public static function getIpAddress() {
        if (isset($_SERVER['X-Forwarded-For'])) {
            return $_SERVER['X-Forwarded-For'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Method used to parse last name
     * @param String $name full name
     * @return String last name
     */
    public static function getLastName($name) {
        $x = explode(' ', $name);
        return $x[count($x) - 1];
    }

    /**
     * Methode used to generate unique offer code
     * @param type $db database connection
     * @param type $company company ID
     * @return type unique offer code for each company
     */
    public static function generateOfferCode($db, $company) {
        while (true) {
            $code = rand(1000, 9999);
            $st = $db->prepare('SELECT '
                    . 'a.des_del_id, '
                    . 'a.des_code, '
                    . 'b.del_com_id '
                    . 'FROM tbl_deal_issued a '
                    . 'INNER JOIN tbl_deal b ON a.des_del_id=b.del_id '
                    . 'WHERE '
                    . 'a.des_code="' . $code . '" AND '
                    . 'b.del_com_id="' . $company . '" AND '
                    . 'a.des_redeem_datetime <> 0');
            $st->execute();
            if ($st->rowCount() == 0) {
                return $code;
            }
        }
    }

    /**
     * Methode used to generate unique offer serial number
     * @param type $db database connection
     * @return type unique offer serial number
     */
    public static function generateOfferSerialNumber($db) {
        while (true) {
            $sn = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
            $st = $db->prepare('SELECT '
                    . 'a.del_id, '
                    . 'a.des_sn '
                    . 'FROM tbl_deal_issued a '
                    . 'WHERE '
                    . 'a.des_sn="' . $sn . '"');
            $st->execute();
            if ($st->rowCount() == 0) {
                return $sn;
            }
        }
    }

    /**
     * 
     * @param type $db connection
     * @param type $value value to generate
     * @return String generated code
     */
    public static function generateQrCode($db, $value) {
        $code = '';
        try {
            $db->beginTransaction();
            $st = $db->prepare('DELETE FROM tbl_qrcode WHERE qrc_value="' . $value . '" OR (UNIX_TIMESTAMP() - qrc_timestamp > 300)');
            $st->execute();
            while (true) {
                $code = md5(rand());
                $st = $db->prepare('SELECT * FROM tbl_qrcode a WHERE a.qrc_code="' . $code . '"');
                $st->execute();
                if ($st->rowCount() == 0) {
                    $st = $db->prepare('INSERT INTO tbl_qrcode SET '
                            . 'qrc_code="' . $code . '", '
                            . 'qrc_value="' . $value . '", '
                            . 'qrc_timestamp=UNIX_TIMESTAMP()');
                    $st->execute();
                    break;
                }
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
        return $code;
    }

    /**
     * Methode used to generate unique reward code
     * @param type $db database connection
     * @param type $company company ID
     * @return type unique reward code for each company
     */
    public static function generateRewardCode($db, $company) {
        while (true) {
            $code = rand(1000, 9999);
            $st = $db->prepare('SELECT '
                    . 'a.lpd_id, '
                    . 'a.lpr_voucher_code, '
                    . 'b.lpr_com_id '
                    . 'FROM tbl_loyalty_point_redeem a '
                    . 'INNER JOIN tbl_loyalty_point_reward b ON a.lpd_lpr_id=b.lpr_id '
                    . 'WHERE '
                    . 'a.lpr_voucher_code="' . $code . '" AND '
                    . 'b.lpr_com_id="' . $company . '"');
            $st->execute();
            if ($st->rowCount() == 0) {
                return $code;
            }
        }
    }

    /**
     * Methode used to generate unique reward serial number
     * @param type $db database connection
     * @return type unique reward serial number
     */
    public static function generateRewardSerialNumber($db) {
        while (true) {
            $sn = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
            $st = $db->prepare('SELECT '
                    . 'a.lpd_id, '
                    . 'a.lpr_sn '
                    . 'FROM tbl_loyalty_point_redeem a '
                    . 'WHERE '
                    . 'a.lpr_sn="' . $sn . '"');
            $st->execute();
            if ($st->rowCount() == 0) {
                return $sn;
            }
        }
    }

    /**
     * Methos used to parse params
     * @return Array array of params
     */
    public static function getParams() {
        $params = Array();
        $index = 0;
        $request = explode('/', $_REQUEST['v']);
        for ($i = 0; $i < count($request); $i++) {
            if (!empty($request[$i])) {
                $params[$index++] = $request[$i];
            }
        }
        return $params;
    }

    public static function getPoint($db, $company, $member, $customer, $type, $value) {
        // get type
        $st = $db->prepare('SELECT '
                . 'a.lpe_id, '
                . 'a.lpe_daily_cap, '
                . 'a.lpe_hourly_cap, '
                . 'a.lpe_point, '
                . 'a.lpe_valid '
                . 'FROM tbl_loyalty_point_type a '
                . 'WHERE a.lpe_id="' . $type . '"');
        $st->execute();
        $cap = $st->fetch(PDO::FETCH_BOTH);
        $valid = $cap['UNIX_TIMESTAMP()'];
        if (!$valid || $valid == '') {
            $valid = 365;
        }
        // check hourly cap
        $hour = true;
        $st = $db->prepare('SELECT '
                . 'COUNT(*) count '
                . 'FROM tbl_loyalty_point_history a '
                . 'WHERE '
                . 'a.lph_mem_id="' . $member . '" AND '
                . 'a.lph_type="C" AND '
                . '(a.lph_datetime BETWEEN UNIX_TIMESTAMP() - 3600 AND UNIX_TIMESTAMP())');
        $st->execute();
        $record = $st->fetch(PDO::FETCH_BOTH);
        if ($record['count'] >= $cap['lpe_hourly_cap']) {
            $hour = false;
        }
        // check daily cap
        $day = true;
        $st = $db->prepare('SELECT '
                . 'COUNT(*) count '
                . 'FROM tbl_loyalty_point_history a '
                . 'WHERE '
                . 'a.lph_mem_id="' . $member . '" AND '
                . 'a.lph_type="C" AND '
                . 'DATE_FORMAT(sysdate(),"%Y-%m-%d")=DATE_FORMAT(a.lph_datetime,"%Y-%m-%d")');
        $st->execute();
        $record = $st->fetch(PDO::FETCH_BOTH);
        if ($record['count'] >= $cap['lpe_daily_cap']) {
            $day = false;
        }
        $point = 0;
        if ($hour && $day) {
            // got point
            $point = $cap['lpe_point'];
            $st = $db->prepare('SELECT '
                    . 'IF(SUM(a.lph_current_point) IS NULL, 0, SUM(a.lph_current_point)) total '
                    . 'FROM tbl_loyalty_point_history a'
                    . 'WHERE '
                    . 'a.lph_mem_id="' . $member . '" AND '
                    . 'a.lph_expired >= UNIX_TIMESTAMP(CONCAT(CURRENT_DATE," 00:00:00")) AND '
                    . 'a.lph_type="C"');
            $st->execute();
            $record = $st->fetch(PDO::FETCH_BOTH);
            $lastPoint = $record['total'];
            // insert intp point detail
            try {
                $db->beginTransaction();
                $st = $db->prepare('INSERT INTO tbl_loyalty_point_history SET '
                        . 'lph_mem_id="' . $member . '", '
                        . 'lph_com_id="' . $company . '", '
                        . 'lph_cus_id="' . $customer . '", '
                        . 'lph_lpe_id="' . $type . '", '
                        . 'lph_param="' . $value . '",'
                        . 'lph_amount="' . $point . '", '
                        . 'lph_type="C", '
                        . 'lph_datetime=UNIX_TIMESTAMP(), '
                        . 'lph_total_point="' . ($lastPoint + $point) . '", '
                        . 'lph_expired=UNIX_TIMESTAMP()+' . $valid . '*86400, '
                        . 'lph_current_point="' . $point . '"');
                $st->execute();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
            }
        }
        return $point;
    }

    /**
     * Method used to get json request
     * @return String json request
     */
    public static function getRequest() {
        if (isset($_REQUEST['r'])) {
            return $_REQUEST['r'];
        }
        return '{}';
    }

    /**
     * Method used to validate name
     * @param String $name fullname, first, middle and last name
     * @return boolean true if valid
     */
    public static function isValidName($name) {
        // todo validate name
        return true;
    }

    /**
     * Method used to validate email
     * @param String $email email address
     * @return boolean true if valid
     */
    public static function isValidEmail($email) {
        // todo validate email
        return true;
    }

    /**
     * Method used to validate gender
     * @param String $gender gender
     * @return boolean true if valid
     */
    public static function isValidGender($gender) {
        // todo validate email
        return true;
    }

    /**
     * Method used to validate password
     * @param String $password password
     * @return boolean true if valid
     */
    public static function isValidPasswordContent($password) {
        // todo validate password content
        return true;
    }

    /**
     * Method used to validate password
     * @param String $password password
     * @return int length of required, 0 if valid
     */
    public static function isValidPasswordLength($password) {
        $length = strlen($password);
        return $length < 8 ? 8 : 0;
    }

    /**
     * Method used to validate phone number
     * @param String $number phone number
     * @return boolean true if valid
     */
    public static function isValidPhoneNumber($number, $international = true) {
        // todo validate phone number
        return true;
    }

    /**
     * Method used to send apns 
     * @param Object $message message
     * @return boolean true if valid
     */
    public static function apns($token, $message) {
        $passphrase = 'manis4$';
        $context = stream_context_create();
        stream_context_set_option($context, 'ssl', 'local_cert', '../core/ck-dev.pem');
        stream_context_set_option($context, 'ssl', 'passphrase', $passphrase);
        $socket = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $errorCode, $errorMessage, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $context);
        $payload = json_encode($message);
        $body = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($socket, $body, strlen($body));
        fclose($socket);

        $context = stream_context_create();
        stream_context_set_option($context, 'ssl', 'local_cert', '../core/ck.pem');
        stream_context_set_option($context, 'ssl', 'passphrase', $passphrase);
        $socket = stream_socket_client('ssl://gateway.push.apple.com:2195', $errorCode, $errorMessage, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $context);
        $payload = json_encode($message);
        $body = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($socket, $body, strlen($body));
        fclose($socket);
        return true;
    }

    /**
     * Method used to validate date
     * @param String $date date
     * @return boolean true if valid
     */
    public static function isValidDate($date) {
        // todo validate email
        return true;
    }

    /**
     * Method used to validate time
     * @param String $time time
     * @return boolean true if valid
     */
    public static function isValidTime($time) {
        // todo validate time
        return true;
    }

    /**
     * Method used to validate date time
     * @param String $dateTime date time
     * @return boolean true if valid
     */
    public static function isValidDateTime($dateTime) {
        // todo validate date time
        return true;
    }

    /**
     * Method used to validate 
     * @param String $username username
     * @return boolean true if valid
     */
    public static function isValidUsername($username) {
        // todo validate name
        return true;
    }

    /**
     * Method to read file content
     * @param String $filename file name
     */
    public static function read($filename) {
        $handler = fopen($filename, 'r');
        $content = fread($handler, filesize($filename));
        fclose($handler);
        return $content;
    }

    /**
     * Method used to send email via ses client
     * @param String $recipient recipient
     * @param String $subject subject
     * @param String $message message body
     */
    public static function sendEmail($sender, $recipient, $subject, $message) {
        if (!Ebizu::$SES) {
            Ebizu::$SES = SesClient::factory(
                            array(
                                'key' => Ebizu::AWS_KEY,
                                'secret' => Ebizu::AWS_ACCES_KEY,
                                'region' => Ebizu::AWS_SES_REGION,
            ));
        }
        Ebizu::$SES->sendEmail(
                array(
                    'Source' => Ebizu::subtitute(Ebizu::EMAIL_SENDER, array($sender)),
                    'Destination' => array(
                        'ToAddresses' => array($recipient)
                    ),
                    'Message' => array(
                        'Subject' => array(
                            'Data' => $subject
                        ),
                        'Body' => array(
                            'Text' => array(
                                'Data' => strip_tags($message)
                            ),
                            'Html' => array(
                                'Data' => $message
                            ),
                        ),
                    )
        ));
    }

    /**
     * Method used to send facebook message
     * @param String $id facebook id
     * @param String $subject subject
     * @param String $message message body
     * @param String $token facebook token
     */
    public static function facebookInvitation($sender, $recipient, $token) {
        if (!Ebizu::$FB) {
            Ebizu::$FB = new Facebook(Ebizu::facebookConfig());
            $FB = new Facebook(Ebizu::facebookConfig());
        }
        $attachment = array(
//            'name' => 'Join Manis',
//            'picture' => 'https://api.ebizu.com/manis.png',
//            'link' => 'http://getmanis.com',
//            'caption' => 'get exclusive offers & rewards and interact with your favourite businesses. Discover, engage, and share your favourite local businesses and enjoy loads of great stuffs.',
            'template' => '@[' . $sender . '] invite you to join Manis',
            'access_token' => Ebizu::$FB->getAccessToken()
        );
        Ebizu::$FB->api('/' . $recipient . '/notifications/', 'post', $attachment);
    }

    /**
     * Method used to subtitude array parameters to string text
     * e.g. 
     * @param String $text text to subtitute
     * @param Array $params array to subtitude
     */
    public static function subtitute($text, $params) {
        if (is_array($params)) {
            for ($i = 0; $i < count($params); $i++) {
                if (!strpos($params[$i], '?')) {
                    $text = preg_replace('/\?/', $params[$i], $text, 1);
                } else {
                    break;
                }
            }
        } else {
            $text = str_replace('?', $params, $text);
        }
        return $text;
    }

    /**
     * Method used to generate success
     * @return Array sucess
     */
    public static function success($data = array()) {
        $result = array();
        //Ebizu::createResult($result['d'], $data);
        $result['d'] = $data ? $data : (object) array();
        return $result;
    }

    /**
     * Method used to generate object result
     * @param type $root object result
     * @param type $data object or array to dive
     */
//    private static function createResult(&$root, $data) {
//        foreach ($data as $key => $val) {
//            if (is_array($val) || is_object($val)) {
//                if (!Ebizu::emptyObject($val)) {
//                    Ebizu::createResult($root[$key], $val);
//                }
//            } else {
//                if ($val) {
//                    $root[$key] = $val;
//                }
//            }
//        }
//    }

    /**
     * Method used to check object or array is empty
     * @param type $data Object or Array
     * @return boolean true if empty
     */
    private static function emptyObject($data) {
        foreach ($data as $key => $val) {
            if ($val) {
                return false;
            }
        }
        return true;
    }

}

?>
