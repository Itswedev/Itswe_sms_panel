<?php
$log_file = "../../error/logfiles/usermanagment.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);


class usermanagment {

    function userLogin($data = null) {
        global $dbc;
        if ($_POST['user_name'] != '' && $_POST['user_psw'] != '') {
            $username = $this->antiinjection($_POST['user_name']);
            $psw = $this->antiinjection($_POST['user_psw']);
            //"SELECT * FROM az_user WHERE user_name = '{$_POST['user_name']}' AND user_psw = '{$_POST['user_psw']}' LIMIT 1"; die;
            $q = mysqli_query($dbc, "SELECT * FROM az_user WHERE user_name = '{$username}' AND user_psw = '{$psw}' LIMIT 1");
            $count = mysqli_num_rows($q);
            $row = mysqli_fetch_assoc($q);
            if ($count > 0) {
                //if($row['user_name'] == $data['user_name'] && $row['user_psw'] == $data['user_psw']){	
                $ip_address = $_SERVER['HTTP_HOST'];
                //session_start();
                $_SESSION['user_id'] = $row['userid'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_role'] = $row['user_role'];
                $sql = mysqli_query($dbc, "insert into az_user_activity (userid,login_date,logout_date,user_ip) VALUES ('" . $_SESSION['user_id'] . "',now(),null,'" . $ip_address . "')");
                if ($sql) {
                    $last_inserted_id = mysqli_insert_id($dbc);
                    $_SESSION['user_details_id'] = $last_inserted_id;
                    echo true;
                } else {
                    echo false;
                }
            } else {
                //echo 'Invalid username and password';
                $host = $_SERVER['HTTP_HOST'];
                header('location:"' . $host . '"index.php?msg=2');
            }
        } else {
            echo 'Please fill username and password';
        }
    }

    function userlogout($data = null) {
        global $dbc;
        $ud_id = $_SESSION['user_details_id'];
        $query = "UPDATE az_user_activity SET logout_date='" . date("Y-m-d H:i:s") . "' WHERE ud_id='" . $_SESSION['user_details_id'] . "'";
        mysqli_query($dbc, $query);
        session_unset();
        session_destroy();
        echo TRUE;
    }

    // This function uesed to create a new client or user

    function createNewClient() {
        global $dbc;
        if (valid_token($_POST['hf']) && $_SESSION[SESS . 'id'] == 1) { // checking if post value is same as timestamp stored in session during form load
            mysqli_query($dbc, "START TRANSACTION");
            if ($_POST['user_psw'] != $_POST['conf_user_psw']) {
                return 'error_msg';
            }
            if ((isset($_SESSION['deduct']) && $_SESSION['deduct'] == 1) || isset($_SESSION['OverSelling']) && $_SESSION['OverSelling'] == "OverSelling") {
                $user_type = "Y";
            } else {
                $user_type = "t";
            }

            $currentLevel = ($this->getUserCurrentLevel($_SESSION['user_id']) + 1);

            $premission = $this->getPermissionResllerData();
            if ($premission != "") {
                $premArr = explode(',', $premission);
                if (in_array('DND_OR_NOT', $premArr)) {
                    $per = 'DND_OR_NOT';
                }
            }
            $qry = 'INSERT INTO `az_user` (`userid`, `parent_id`, `user_role`, `user_name`, `user_psw`, `client_name`, `company_name`, `email_id`, `mobile_no`, `address`, `user_status`, `created`, `user_type`, `permissions`,`user_level`) VALUES (NULL, ' . $_SESSION['user_id'] . ', ' . $_POST['user_role'] . ', "' . $_POST['user_name'] . '", "' . $_POST['user_psw'] . '", "' . $_POST['client_name'] . '", "' . $_POST['company_name'] . '", "' . $_POST['email_id'] . '", "' . $_POST['mobile_no'] . '", "' . $_POST['address'] . '", 1, NOW(), "' . $user_type . '", "' . $per . '", "' . $currentLevel . '")';
            $res = mysqli_query($dbc, $qry);
            $rid = mysqli_insert_id($dbc);
            if ($_SESSION['user_id'] != 1) {
                $this->checkLowPrice($rid, $_POST['az_routeid']);
            }
            $str = $str1 = array();
            foreach ($_POST['az_routeid'] as $key => $val) {
                $str[] = '(' . $val . ', ' . $rid . ')';
                $str1[] = '(NULL, ' . $rid . ', ' . $val . ', 0)';
                //mysqli_query($dbc, "INSERT INTO `az_balance` (`bid`, `userid`, `routeid`, `total_balance`) VALUES (NULL, '{$rid}', '{$val}', '0');");
            }

            $qry_1 = "INSERT INTO `az_user_services` (`service_id`, `userid`) VALUES " . implode(', ', $str);
            $res_1 = mysqli_query($dbc, $qry_1);
            $qry_2 = "INSERT INTO `az_balance` (`bid`, `userid`, `routeid`, `total_balance`) VALUES " . implode(', ', $str1);
            $res_2 = mysqli_query($dbc, $qry_2);

            if ($res != false && $res_1 != false && $res_2 != false) {
                mysqli_commit($dbc);
                return 'Success';
            } else {
                mysqli_rollback($dbc);
                return 'Failed';
            }
        } else {
            return 'Failed';
        }
    }

    function getClientList($start = null, $end = null) {
        global $dbc;
        $out = array();
        $cond = "WHERE 1  ";
        if ($_SESSION['user_id'] != 1) {
            $cond .= "  AND parent_id != 0";
            $cond .= "  AND parent_id = {$_SESSION['user_id']}";
        }

        if (isset($_POST['uid']) && !empty($_POST['uid'])) {
            $cond .= " AND userid = {$_POST['uid']}";
        }
        /* if(!empty($uname)){
          $cond .= " AND user_name = '$uname'";
          }
          if(!empty($addition)){
          $cond .= " AND user_name = '$addition'";
          } */
        //$limit = " LIMIT  $start, $end";
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $cond .= " AND user_name = '{$_POST['username']}'";
        }
        if (isset($_POST['company']) && !empty($_POST['company'])) {
            $cond .= " AND company_name LIKE '{$_POST['company']}%'";
        }
        $limit = isset($start) && isset($start) ? " LIMIT  $start, $end" : '';
        $qry = "SELECT COUNT(*) as tot FROM az_user $cond";
        $rs_count = mysqli_query($dbc, $qry);
        $countRows = mysqli_fetch_assoc($rs_count);
        $count = $countRows['tot'];
        if (isset($_POST['uid']) && !empty($_POST['uid'])) {
            $q = "SELECT * FROM az_user $cond  ORDER BY created DESC $limit";
        } else {
            $q = "SELECT userid, parent_id, user_role, user_name, client_name, company_name, email_id, mobile_no, user_status FROM az_user $cond  ORDER BY created DESC $limit";
        }
        //echo $q;
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['userid'];
            $out[$id] = $row;
            if ($_SESSION['user_id'] == 1) {
                $out[$id]['belongsto'] = $this->userBelongsTo($row['parent_id']);
            } else {
                $out[$id]['belongsto'] = '';
            }
            $out[$id]['route'] = $this->getBalanceRoute($id);
        }
        //pre($out);
        //mysqli_free_result($rs);
        //mysqli_close($dbc);
        mysqli_free_result($rs);
        return array('result' => $out, 'count' => $count);
    }

    function userBelongsTo($parent_id) {
        global $dbc;
        $out = '';
        $qry = "SELECT parent_id, user_name FROM az_user WHERE userid = '{$parent_id}' AND parent_id !=0 ";
        $rs = mysqli_query($dbc, $qry);
        if (mysqli_num_rows($rs)) {
            $row = mysqli_fetch_assoc($rs);
            $out = $row['user_name'];
            $out1 = $this->userBelongsTo($row['parent_id']);
        }
        if (!empty($out1)) {
            $result = $out1 . ' => ' . $out;
        } else {
            $result = $out;
        }
        return $result;
    }

    function getBalanceRoute($userid) {
        global $dbc;
        $qry = "SELECT az_routeid, az_rname, total_balance as Balance FROM `az_balance` INNER JOIN `az_routetype` ON `az_balance`.routeid = `az_routetype`.az_routeid WHERE userid = '{$userid}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $out[$row['az_routeid']]['az_routeid'] = $row['az_routeid'];
                $out[$row['az_routeid']]['az_rname'] = $row['az_rname'];
                $out[$row['az_routeid']]['Balance'] = $row['Balance'];
            }
            return $out;
        }
        return $out;
    }

    function getClientListWidLowCredits($uid = null, $start = null, $end = null, $uname = null) {
        global $dbc;
        $out = array();
        $cond = "WHERE 1  ";
        $cond .= "  AND parent_id = 1";
        if (!empty($uid)) {
            $cond .= " AND userid = $uid";
        }
        if (!empty($uname)) {
            $cond .= " AND user_name = '$uname'";
        }
        if (!empty($addition)) {
            $cond .= " AND user_name = '$addition'";
        }
        //$limit = " LIMIT  $start, $end";
        $limit = isset($start) && isset($start) ? " LIMIT  $start, $end" : '';
        $qry = "SELECT * FROM az_user $cond";
        $rs_count = mysqli_query($dbc, $qry);
        $count = mysqli_num_rows($rs_count);
        //$q = "SELECT * FROM az_user $cond  ORDER BY created DESC $limit";
        echo $q = "SELECT * FROM az_user INNER JOIN az_balance USING(userid)  $cond  ORDER BY total_balance ASC $limit";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['userid'];
            $out[$id] = $row;
            $out[$id]['route'] = $this->getBalanceRoute($id);
        }
        //pre($out);
        //mysqli_free_result($rs);
        //mysqli_close($dbc);
        return array('result' => $out, 'count' => $count);
    }

    function getUserRoute($userid, $user_role) {
        global $dbc;
        $out = array();
        $q = "SELECT az_routeid, az_rname FROM az_user_services LEFT JOIN az_routetype ON az_user_services.service_id = az_routetype.az_routeid WHERE userid = $userid";
        $rs1 = mysqli_query($dbc, $q);
        if (mysqli_num_rows($rs1) > 0) {
            while ($rows1 = mysqli_fetch_assoc($rs1)) {
                $avlbal = '';
                $balance = $this->userCredit($rows1['az_routeid'], $userid, $user_role);
                foreach ($balance as $val) {
                    $avlbal = $val['Balance'];
                }
                $out[$rows1['az_routeid']] = $rows1;
                $out[$rows1['az_routeid']]['Balance'] = (isset($avlbal) && !empty($avlbal)) ? $avlbal : '0';
            }
        } else {
            $out[0] = array();
        }
        //pre($out);
        return $out;
    }

    // This function get statename list
    function getStateList() {
        global $dbc;
        $out = array();
        $q = "SELECT * FROM az_state ORDER BY statename ASC";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['stateid'];
            $out[$id] = $row;
        }
        return $out;
    }

    function updateUser() {
        global $dbc;
        /* pre($_POST);
          die; */
        if ($_POST['user_psw'] != $_POST['conf_user_psw']) {
            echo 'error_msg';
            return false;
        }
        mysqli_query($dbc, "START TRANSACTION");
        $is_cutting = isset($_POST['is_cutting']) ? $_POST['is_cutting'] : '0';
        $start_num_from = isset($_POST['is_cutting']) ? $_POST['start_num_from'] : '0';
        $pre_cutting = (isset($_POST['pre_cutting']) AND $_POST['pre_cutting'] != 0) ? $_POST['pre_cutting'] : '0';
        $stop_sending_msg = isset($_POST['stop_sending_msg']) ? $_POST['stop_sending_msg'] : '0';
        $company_name = $this->antiinjection($_POST['company_name']);
        //$till_date = $this->DateFormateMDY($_POST['till_valid_edit']);
        //$till_date = (($till_date != '')? $till_date: '1970-01-01');
        //mysqli_query($dbc, "UPDATE az_user_activity SET login_date = now() WHERE userid='" .$_POST['userid']. "' AND userid != 1 ORDER BY ud_id  DESC LIMIT 1");
        $q = "UPDATE `az_user` SET `user_role` = '{$_POST['user_role']}', `user_name` =  '{$_POST['user_name']}', `user_psw` =  '{$_POST['user_psw']}', `client_name`= '{$_POST['client_name']}', `company_name` = '{$company_name}', `email_id` =  '{$_POST['email_id']}', `mobile_no` = '{$_POST['mobile_no']}', `address` = '{$_POST['address']}', `user_status` = '{$_POST['user_status']}', `email_verify` = 1, `is_cutting` = '{$is_cutting}', `start_num_from`= '{$start_num_from}', `pre_cutting` = '{$pre_cutting}', `stop_sending_msg` = '{$stop_sending_msg}', chg_psw_status = 1  WHERE `userid` = '{$_POST['userid']}'";

        $rs = mysqli_query($dbc, $q);
        $str = array();
        $qry = "SELECT routeid FROM `az_balance` WHERE `userid` = '{$_POST['userid']}'";
        $result = mysqli_query($dbc, $qry);
        $exist = array();
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                if (in_array($data['routeid'], $_POST['az_routeid'])) {
                    $exist[] = $data['routeid'];
                } else {
                    mysqli_query($dbc, "DELETE FROM az_balance WHERE userid =  '{$_POST['userid']}' AND `routeid` = '{$data['routeid']}'");
                }
            }
        }
        //die;
        mysqli_query($dbc, "DELETE FROM az_user_services WHERE `userid` = '{$_POST['userid']}'");

        foreach ($_POST['az_routeid'] as $key => $val) {
            $str[] = "('$val', '{$_POST['userid']}')";
            if (!in_array($val, $exist)) {
                mysqli_query($dbc, "INSERT INTO `az_balance` (`bid`, `userid`, `routeid`, `total_balance`) VALUES (NULL, '{$_POST['userid']}', '{$val}', '0');");
            }
        }
        $str = implode(', ', $str);
        $rs1 = mysqli_query($dbc, "INSERT INTO `az_user_services` (`service_id`, `userid`) VALUES $str");
        if (!$rs && !$rs1) {
            mysqli_rollback($dbc);
            return false;
        } else {
            unset($_POST);
            mysqli_commit($dbc);
            return true;
        }
    }

    // This function used to check the unique number
    function checkUniqueUser($username = null) {
        global $dbc;
        $q = "SELECT user_name FROM `az_user` WHERE `user_name` =  '{$username}'";
        $rs = mysqli_query($dbc, $q);
        $out = mysqli_num_rows($rs);
        return $out > 0 ? true : false;
    }

    function getUserList() {
        global $dbc;
        $cond = "WHERE 1";
        if ($_SESSION['user_id'] != 1) {
            $cond .= "  AND parent_id = {$_SESSION['user_id']}";
        }
        $out = array();
        $q = "SELECT userid, user_name FROM `az_user` $cond";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['userid'];
            $out[$id] = $row;
        }
        return $out;
    }

    function assignCredit() {
        global $dbc;

//                if ($_SESSION['token'] != $_POST['token']) {
//                    return array('status'=>false, 'msg'=>'Faied');
//                    exit();
//                }

        if (valid_token($_POST['hf']) && $_SESSION[SESS . 'id'] == 1) { // checking if post value is same as timestamp stored in session during form load
            $debit = $credit = '';
            if (!is_numeric($_POST['assign_credit']) || $_POST['assign_credit'] < 0) {
                return array('status' => false, 'msg' => 'typeNumeric');
            }
            //pre($_SESSION);die;
            mysqli_query($dbc, "START TRANSACTION");
            if ($_POST['credit_mode'] == 1) {
                $userbalance = $this->userCreditBalance($_SESSION['user_id'], $_POST['az_routeid']);
                $credit = $_POST['assign_credit'];
                if ($userbalance < $credit && $_SESSION['user_id'] != 1 && (!isset($_SESSION['OverSelling']) || $_SESSION['OverSelling'] != 'OverSelling')) {
                    return array('status' => false, 'msg' => 'Insufficient Balance');
                    exit;
                }
                $qry = "UPDATE `az_balance` SET total_balance = (total_balance+$credit) WHERE userid = '{$_POST['customer_id']}' AND routeid = '{$_POST['az_routeid']}'";
                if ($_SESSION['user_id'] != 1 && (!isset($_SESSION['OverSelling']) || $_SESSION['OverSelling'] != 'OverSelling')) {
                    $qry1 = "UPDATE `az_balance` SET total_balance = (total_balance-$credit) WHERE userid = '{$_SESSION['user_id']}' AND routeid = '{$_POST['az_routeid']}'";
                    $rs2 = mysqli_query($dbc, $qry1);
                }
            } else {
                $userbalance = $this->userCreditBalance($_POST['customer_id'], $_POST['az_routeid']);
                $debit = $_POST['assign_credit'];
                if ($userbalance < $debit && $_SESSION['user_id'] != 1 && (!isset($_SESSION['OverSelling']) || $_SESSION['OverSelling'] != 'OverSelling')) {
                    return array('status' => false, 'msg' => 'Insufficient Balance Deduction', 'credit' => $userbalance);
                    exit;
                }
                $qry = "UPDATE `az_balance` SET total_balance = (total_balance-$debit) WHERE userid = '{$_POST['customer_id']}' AND routeid = '{$_POST['az_routeid']}'";
                if ($_SESSION['user_id'] != 1 && (!isset($_SESSION['OverSelling']) || $_SESSION['OverSelling'] != 'OverSelling')) {
                    $qry1 = "UPDATE `az_balance` SET total_balance = (total_balance+$debit) WHERE userid = '{$_SESSION['user_id']}' AND routeid = '{$_POST['az_routeid']}'";
                    $rs2 = mysqli_query($dbc, $qry1);
                }
            }

            $q = "INSERT INTO `az_credit_manage` 
			(`crmid`, `userid`, `customer_id`, `az_routeid`, `assign_credit`, `debit_credit`, `balance`, `credit_mode`,  `account_manager`, `remark` ,`created`) 
	 VALUES (NULL, '{$_SESSION['user_id']}', '{$_POST['customer_id']}', '{$_POST['az_routeid']}', '$credit', '$debit', '', '{$_POST['credit_mode']}', '{$_POST['account_manager']}', '{$_POST['remark']}', NOW())";
            $rs = mysqli_query($dbc, $q);
            $rs1 = mysqli_query($dbc, $qry);
            if ($rs && $rs1) {
                mysqli_commit($dbc);
                return array('status' => true, 'msg' => 'Success');
            } else {
                mysqli_rollback($dbc);
                return array('status' => false, 'msg' => 'Faied');
            }
        } else {
            return array('status' => false, 'msg' => 'Faied');
        }
    }

    function userCreditBalance($userid, $routeid) {
        global $dbc;
        $qry = "SELECT total_balance as Balance FROM `az_balance` WHERE userid = '{$userid}' AND routeid = '{$routeid}'";
        $rs = mysqli_query($dbc, $qry);
        $out = 0;
        if (mysqli_num_rows($rs)) {
            $row = mysqli_fetch_assoc($rs);
            $out = $row['Balance'];
            return $out;
        }
        return $out;
    }

    // this function used for show the listing of assign credit list
    function assignCreditList($start = null, $end = null) {
        global $dbc;
        $out = array();
        //$this->creditBalace($_SESSION['user_id']);
        $cond = "WHERE 1";
        ///if($_SESSION['user_id'] !=1) {

        if ($_SESSION['user_role'] == 2)
            $cond .= " AND az_credit_manage.customer_id = {$_SESSION['user_id']}";
        else
            $cond .= " AND az_credit_manage.userid = {$_SESSION['user_id']}";

        if (!empty($uname)) {
            $cond .= " AND user_name = '$uname'";
        }
        $limit = isset($start) && isset($start) ? " LIMIT  $start, $end" : '';

        $qry = "SELECT COUNT(crmid), az_credit_manage.*, SUM(assign_credit) as credit, SUM(debit_credit) as debit, user_name,  az_rname, user_role FROM `az_credit_manage` INNER JOIN az_user ON az_credit_manage.customer_id = az_user.userid INNER JOIN az_routetype USING(az_routeid) $cond GROUP BY user_name, az_routeid ORDER BY `crmid` DESC ";
        $rs_count = mysqli_query($dbc, $qry);
        $count = mysqli_num_rows($rs_count);

        $q = "SELECT COUNT(crmid), az_credit_manage.*, SUM(assign_credit) as credit, SUM(debit_credit) as debit, user_name,  az_rname, user_role FROM `az_credit_manage` INNER JOIN az_user ON az_credit_manage.customer_id = az_user.userid INNER JOIN az_routetype USING(az_routeid) $cond GROUP BY user_name, az_routeid ORDER BY `crmid` DESC $limit";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['crmid'];
            $out[$id] = $row;
            $used_credit = $this->usedCredit($row['customer_id'], $row['az_routeid']);
            $qry = "SELECT total_balance as Balance FROM `az_balance` WHERE userid = '{$row['customer_id']}' AND routeid = '{$row['az_routeid']}'";
            $rs1 = mysqli_query($dbc, $qry);
            $data = mysqli_fetch_assoc($rs1);
            $out[$id]['Balance'] = !empty($data['Balance']) ? $data['Balance'] : 0;
        }
        //$this->pre($out);
        return array('result' => $out, 'count' => $count);
        //return $out;
    }

    function assignCreditList1() {

        global $dbc;

        $out = array();
        $q = "SELECT az_credit_manage.*, DATE_FORMAT(`credit_date`, '%d/%m/%Y') as fdate, user_name, az_rname  FROM `az_credit_manage` INNER JOIN az_user USING(userid) INNER JOIN az_routetype USING(az_routeid) ORDER BY `crmid` DESC";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['crmid'];
            $out[$id] = $row;
        }
        return $out;
    }

    function usedCredit($userid = null, $az_routeid = null) {

        global $dbc;
        $out = array();
        if (!empty($userid) && !empty($az_routeid)) {
            $q = "SELECT SUM(used_balance) as used_credit FROM `az_credit_used` WHERE userid = $userid AND az_routeid = $az_routeid";
            $rs = mysqli_query($dbc, $q);
            $num = mysqli_num_rows($rs);
            if ($num > 0) {
                $row = mysqli_fetch_assoc($rs);
                return $row['used_credit'];
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function userCredit($routeid = null, $userid = null, $user_role = null) {
        global $dbc;
        $out = array();
        $cond = "WHERE 1";
        ///if($_SESSION['user_id'] !=1) {
        /* if($_SESSION['user_role'] == 2)
          $cond .= " AND az_credit_manage.customer_id = {$_SESSION['user_id']}";
          else */
        if (!empty($routeid)) {
            $cond .= " AND az_routetype.az_routeid = {$routeid}";
        } else {
            $qry = "SELECT service_id FROM az_user_services WHERE userid = {$_SESSION['user_id']}";
            $rs1 = mysqli_query($dbc, $qry);
            $serviceArr = array();
            if (mysqli_num_rows($rs1) > 0) {
                while ($record = mysqli_fetch_assoc($rs1)) {
                    $serviceArr[] = $record['service_id'];
                }
            }
            if (!empty($serviceArr)) {
                $ids = implode(',', $serviceArr);
                $cond .= " AND az_routetype.az_routeid IN ($ids)";
            }
        }

        if (!empty($userid)) {
            $cond .= " AND az_credit_manage.customer_id = {$userid}";
        } else {
            $cond .= " AND az_credit_manage.customer_id = {$_SESSION['user_id']}";
        }
        if (!empty($user_role)) {
            $role = $user_role;
        } else {
            $role = $_SESSION['user_role'];
        }
        //}
        //$q = "";
        //az_user ON az_credit_manage.customer_id = az_user.userid INNER JOIN
        $q = "SELECT az_credit_manage.*, SUM(assign_credit) as credit, SUM(debit_credit) as debit, SUM(used_balance) as used_credit, DATE_FORMAT(`credit_date`, '%d/%m/%Y') as fdate, az_rname  FROM `az_credit_manage` INNER JOIN  az_routetype USING(az_routeid)  LEFT JOIN `az_credit_used` USING(userid)  $cond GROUP BY az_routeid  ORDER BY `crmid` DESC";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['crmid'];
            $out[$id] = $row;
            $used_credit = $this->usedCredit($row['customer_id'], $row['az_routeid']);
            $out[$id]['Balance'] = $this->creditBalace($row['customer_id'], $row['az_routeid'], $role) - $used_credit;
        }
        //$this->pre($out);
        return $out;
    }

    // here function for getting the user credit balace
    function creditBalace($id = null, $routeid = null, $user_role = null) {
        global $dbc;
        $out = 0;
        $q = "SELECT SUM(assign_credit) as credit, SUM(debit_credit) as debit FROM `az_credit_manage`  WHERE customer_id = {$id} AND az_credit_manage.az_routeid = $routeid";
        $rs = mysqli_query($dbc, $q);
        $row = mysqli_fetch_assoc($rs);
        $debit = $row['debit'];
        $cedit = $row['credit'] - $debit; // - $row['used_credit'] ;
        if ($user_role == 2) {
            return $cedit;
        } else {
            $uids = $this->getUserIds($id);
        }
        $q1 = "SELECT SUM(assign_credit) as credit1, SUM(debit_credit) as debit1 FROM `az_credit_manage` WHERE customer_id IN($uids) AND customer_id != 1 AND az_routeid = $routeid";
        $rs1 = mysqli_query($dbc, $q1);
        $row1 = mysqli_fetch_assoc($rs1);
        $debit1 = $row1['debit1'];
        $cedit1 = $row1['credit1'] - $debit1;
        return ($cedit - $cedit1);
    }

    // here function used to change the date formate 
    function changedateformate($date = null) {
        $out = '';
        if (!empty($date)) {
            $out = explode('/', $date);
            $out = $out[2] . '-' . $out[1] . '-' . $out[0];
            return $out;
        } else {
            return $out;
        }
    }

    function getUserIds($id = null) {
        global $dbc;
        $out = array();

        if (!empty($id)) {
            $id = $id;
        } else {
            $id = $_SESSION['user_id'];
        }
        $q = "SELECT customer_id FROM `az_credit_manage` WHERE userid = $id GROUP BY customer_id";
        $rs = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($rs);
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $out[] = $row['customer_id'];
            }
            return implode(',', $out);
        } else {
            return 0;
        }
    }

    function getUserProfile() {
        global $dbc;
        $out = array();
        $q = "SELECT * FROM `az_user` WHERE userid = {$_SESSION['user_id']}";
        $rs = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($rs);
        if ($num > 0) {
            $out = mysqli_fetch_assoc($rs);
            return $out;
        } else {
            return $out;
        }
    }

    function UpdateProfile() {
        global $dbc;
        $q = "UPDATE `az_user` SET `client_name`= '{$_POST['client_name']}', `company_name` = '{$_POST['company_name']}', `email_id` =  '{$_POST['email_id']}', `mobile_no` = '{$_POST['mobile_no']}', `address` = '{$_POST['address']}', `statename` = '{$_POST['statename']}' , `city` = '{$_POST['city']}', `pincode` = '{$_POST['pincode']}', `website` = '{$_POST['website']}', `faxno` = '{$_POST['faxno']}' WHERE `userid` = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $q);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    function updatePassword() {
        global $dbc;
        if (!empty($_POST['old_psw'])) {
            $q = "SELECT user_psw FROM `az_user` WHERE `userid` = '{$_SESSION['user_id']}'";
            $rs = mysqli_query($dbc, $q);
            $num = mysqli_num_rows($rs);
            if ($num > 0) {
                $out = mysqli_fetch_assoc($rs);
                if ($out['user_psw'] != $_POST['old_psw']) {
                    echo 'error';
                    exit;
                }
                if ($out['user_psw'] == $_POST['new_psw']) {
                    echo 'errorOccured';
                    exit;
                }
            }
        }
        $qry = "UPDATE `az_user` SET `user_psw`= '{$_POST['new_psw']}', chg_psw_status = 1   WHERE `userid` = '{$_SESSION['user_id']}'";
        $rs1 = mysqli_query($dbc, $qry);
        if ($rs1) {
            return true;
        } else {
            return false;
        }
    }

    function viewCreditData() {
        global $dbc;
        $out = array();
        $q = "SELECT az_credit_manage.*, az_routetype.az_rname FROM `az_credit_manage` INNER JOIN az_routetype USING(az_routeid) WHERE customer_id = {$_POST['customer_id']}";
        $rs = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($rs);
        if ($num > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[$rows['crmid']] = $rows;
            }
        }
        return $out;
    }

    function assignSenderidsToUser() {
        global $dbc;
        $out = array();
        if (!empty($_POST['sid'])) {
            $sid = implode(',', $_POST['sid']);
            $q = "UPDATE `az_senderid` SET userid = '{$_POST['userid']}' WHERE sid IN($sid)";
            $rs = mysqli_query($dbc, $q);
            if ($rs) {
                return true;
            } else {
                return false;
            }
        } else {
            return 'select senderids';
        }
    }

    function pre($value) {
        if (is_array($value)) {
            echo'<pre>';
            print_r($value);
            echo'</pre>';
        } else {
            die('<strong>pre function</strong> takes an <strong>array as argument</strong> the value it got is <b>' . $value . '</b>');
        }
    }

    function antiinjection($data) {
        global $dbc;
        $filter_sql = mysqli_real_escape_string($dbc, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
        return $filter_sql;
    }

    function getPurchaseHistory() {
        global $dbc;
        $out = array();
        $q = "SELECT `crmid`, `assign_credit`, `debit_credit`, `created`, `az_rname` FROM az_credit_manage INNER JOIN `az_routetype` USING(az_routeid) WHERE customer_id = '{$_SESSION['user_id']}' ORDER BY `created` DESC";
        $rs = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($rs);
        if ($num > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[$rows['crmid']] = $rows;
            }
        }
        //mysqli_query($dbc);
        return $out;
    }

    function updateAlerts() {
        global $dbc;
        $stauts = isset($_POST['status']) ? $_POST['status'] : 0;
        $crlimit = isset($_POST['crlimit']) ? $_POST['crlimit'] : null;
        $qry = "SELECT id FROM az_alerts WHERE userid = '{$_SESSION['user_id']}' AND alert_type = '{$_POST['alert_type']}'";
        $rs = mysqli_query($dbc, $qry);
        if (mysqli_num_rows($rs) > 0) {
            $qry1 = "UPDATE az_alerts SET `status` = '{$stauts}', `email` = '{$_POST['email']}', `crlimit` = '{$crlimit}' WHERE userid = '{$_SESSION['user_id']}' AND alert_type = '{$_POST['alert_type']}'";
        } else {
            $qry1 = "INSERT INTO az_alerts(`id`, `userid`, `email`, `status`, `alert_type`, `crlimit`, `created`) values(NULL, '{$_SESSION['user_id']}', '{$_POST['email']}', '{$stauts}', '{$_POST['alert_type']}', '{$crlimit}', NOW())";
        }
        $rs1 = mysqli_query($dbc, $qry1);
        mysqli_query($dbc);
        if ($rs1) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getAlertsData() {
        global $dbc;
        $qry = "SELECT status, email, alert_type, crlimit FROM az_alerts WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $qry);
        $num = mysqli_num_rows($rs);
        $out = array();
        if ($num > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[$rows['alert_type']]['status'] = $rows['status'];
                $out[$rows['alert_type']]['email'] = $rows['email'];
                $out[$rows['alert_type']]['crlimit'] = $rows['crlimit'];
            }
        }
        mysqli_free_result($rs);
        return $out;
    }

    function alertsMailFuntion() {
        global $dbc;
        $q = "SELECT email, userid FROM az_alerts WHERE status = 1 AND email !=''";
        $rs = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($rs);
        $finalarray = array();
        if ($num > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $qry = "SELECT * FROM az_user WHERE userid = '{$rows['userid']}'";
                $result = mysqli_query($dbc, $qry);
                $count = mysqli_num_rows($result);
                if ($count > 0) {
                    $data = mysqli_fetch_assoc($result);
                    if ($data['user_role'] == 1) {
                        $usedcredit = $this->creditUsedByDailyBasis($data['userid']);
                        $avaliblebal = $this->getBalanceRoute($data['userid']);
                        $finalarray[$data['userid']]['Users'][$data['user_name']] = $usedcredit;
                        $finalarray[$data['userid']]['balance'] = $avaliblebal;
                        $finalarray[$data['userid']]['email'] = $rows['email'];
                        $finalarray[$data['userid']]['userrole'] = $data['user_role'];
                        $qry1 = "SELECT * FROM az_user WHERE parent_id = '{$data['userid']}'";
                        $result1 = mysqli_query($dbc, $qry1);
                        $count1 = mysqli_num_rows($result1);
                        if ($count1 > 0) {
                            while ($data1 = mysqli_fetch_assoc($result1)) {
                                $usedcredit = $this->creditUsedByDailyBasis($data1['userid']);
                                $avaliblebal = $this->getBalanceRoute($data1['userid']);
                                //$finalarray[$data['userid']]['endUsase'][$data1['user_name']][''] = $usedcredit;
                                $finalarray[$data['userid']]['endUsase'][$data1['user_name']] = $usedcredit;
                                $finalarray[$data['userid']]['endAvlBal'][$data1['user_name']] = $avaliblebal;
                            }
                        }
                    } else {
                        $usedcredit = $this->creditUsedByDailyBasis($data['userid']);
                        $avaliblebal = $this->getBalanceRoute($data['userid']);
                        $finalarray[$data['userid']]['Users'][$data['user_name']] = $usedcredit;
                        $finalarray[$data['userid']]['balance'] = $avaliblebal;
                        $finalarray[$data['userid']]['email'] = $rows['email'];
                        $finalarray[$data['userid']]['userrole'] = $data['user_role'];
                    }
                }
            }
            /* echo '<br>';
              echo '<br>';
              pre($finalarray); */
            return $finalarray;
        }
    }

    function creditUsedByDailyBasis($userid) {
        global $dbc;
        //$today = date('Ymd');
        $ydate = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " -1 day");
        $today = date('Ymd', $ydate);
        $qry = "SELECT numbers_count, msg_credit, sms_type, DATE_FORMAT(created_at, '%Y%m%d') as fdate, created_at FROM az_sendmessages WHERE userid = '{$userid}' AND DATE_FORMAT(az_sendmessages.`created_at`, '%Y%m%d') = '{$today}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        $crval = 0;
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                if ($rows['sms_type'] == 'Customize SMS') {
                    $credit[] = $rows['msg_credit'];
                } else if ($rows['sms_type'] == 'Personalize SMS') {
                    $credit[] = $rows['msg_credit'];
                } else {
                    $credit[] = $rows['msg_credit'] * $rows['numbers_count'];
                }
                $out['credit'] = $credit;
            }
            $crval = array_sum($out['credit']);
        }
        return $crval;
    }

    /* function savePermissions(){
      global $dbc;
      $permission = array(1=>'Over Selling',2=>'DND Refund or Not',3=>'Mis Report');
      $str = array();
      pre($_GET);exit;
      foreach($permission as $key=>$per){
      if(isset($_GET['permissions'.$key]) && !empty($_GET['permissions'.$key])) {
      $str[$key] = $_GET['permissions'.$key];
      } else {
      $str[$key] = 0;
      }
      }
      if(!empty($_GET['permissions'])) {
      $str = implode(',',$_GET['permissions']);
      $qry = 'REPLACE INTO `az_user_permission` (`id`, `userid`, `parent_id`, `permissions`, `created_at`) VALUES (NULL, "'.$_GET['userid'].'", "'.$_SESSION['user_id'].'", "'.$str.'", NOW());';
      $rs = mysqli_query($dbc, $qry);
      return $rs == 1 ? true : 2;
      } else {
      return 3;
      }
      } */

    /* function getPermissionData(){
      global $dbc;
      $qry = "SELECT * FROM `az_user_permission` WHERE userid = '{$_GET['userid']}'";
      $rs = mysqli_query($dbc, $qry);
      $out = array();
      if(mysqli_num_rows($rs) > 0) {
      $rows = mysqli_fetch_assoc($rs);
      $out = $rows['permissions'];
      }
      return $out;
      }

      function getPermissionResllerData(){
      global $dbc;
      $qry = "SELECT * FROM `az_user_permission` WHERE userid = '{$_SESSION['user_id']}'";
      $rs = mysqli_query($dbc, $qry);
      $out = array();
      if(mysqli_num_rows($rs) > 0) {
      $rows = mysqli_fetch_assoc($rs);
      $out = $rows['permissions'];
      }
      return $out;
      } */

    function savePermissions() {
        global $dbc;
        $permission = array(1 => 'Over Selling', 2 => 'DND Refund or Not', 3 => 'Mis Report');
        $str = array();
        $q = "SELECT * FROM `az_user` WHERE userid = '{$_GET['userid']}'";
        $rs = mysqli_query($dbc, $q);
        $out = array();
        $per = $per1 = false;
        $str = !empty($_GET['permissions']) ? implode(',', $_GET['permissions']) : '';
        if (!empty($_GET['permissions'])) {
            foreach ($_GET['permissions'] as $key => $value) {
                if ($value == 'OverSelling') {
                    $per1 = true;
                }
            }
        }
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['permissions'];
            $data = explode(',', $out);
            foreach ($data as $key => $value) {
                if ($value == 'OverSelling') {
                    $per = true;
                }
            }
        }
        if ($per == false && $per1 == true) {
            $userids = $this->getUserCredit($_GET['userid']);
            if (!empty($userids)) {
                $this->manageBalance($userids, $_GET['userid'], 1);
            }
        } else if ($per == true && $per1 == false) {
            $userids = $this->getUserCredit($_GET['userid']);
            if (!empty($userids)) {
                $this->manageBalance($userids, $_GET['userid'], 2);
            }
        }
        $qry = 'UPDATE `az_user` SET `permissions` = "' . $str . '" WHERE userid = ' . $_GET['userid'] . '';
        $rs1 = mysqli_query($dbc, $qry);
        return $rs1 == 1 ? true : 2;
    }

    function getPermissionData() {
        global $dbc;
        $qry = "SELECT * FROM `az_user` WHERE userid = '{$_GET['userid']}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['permissions'];
        }
        return $out;
    }

    function getPermissionResllerData1() {
        global $dbc;
        $qry = "SELECT * FROM `az_user` WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['permissions'];
        }
        return $out;
    }

    function getPermissionResllerData() {
        global $dbc;
        $qry = "SELECT permissions FROM `az_user` WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $qry);
        $out = "";
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['permissions'];
        }
        return $out;
    }

    function checkOverSellingOption($parent_id) {
        global $dbc;
        $qry = "SELECT `parent_id`, `permissions` FROM `az_user` WHERE userid = '{$parent_id}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        $per = false;
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['permissions'];
            $data = explode(',', $out);
            foreach ($data as $key => $value) {
                if ($value == 'OverSelling') {
                    $per = true;
                }
            }
            if ($per == true) {
                return true;
            } else {
                return $this->checkOverSellingOption($rows['parent_id']);
            }
        } else {
            return false;
        }
    }

    function getUserCredit($userid) {
        global $dbc;
        $qry = "SELECT `userid`, `parent_id`, `user_role` FROM `az_user` WHERE parent_id = '{$userid}'";
        $rs = mysqli_query($dbc, $qry);
        static $ids = array();
        $per = false;
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                if ($rows['user_role'] == 1) {
                    $ids[] = $rows['userid'];
                    $this->getUserCredit($rows['userid']);
                } else {
                    $ids[] = $rows['userid'];
                }
            }
            return $ids;
        } else {
            return $ids;
        }
    }

    function manageBalance($userid, $id, $type) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));
            $qry = "SELECT SUM(total_balance) balance, routeid FROM `az_balance` WHERE userid IN($ids) GROUP BY routeid";
            $rs = mysqli_query($dbc, $qry);
            if ($type == 1) {
                mysqli_query($dbc, "UPDATE `az_user` SET user_type = 'Y' WHERE userid IN($ids)");
            } else {
                $check = $this->checkOverSellingOption($_SESSION['user_id']);
                if ($check == false) {
                    mysqli_query($dbc, "UPDATE `az_user` SET user_type = 't' WHERE userid IN($ids)");
                }
            }
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $balance = $rows['balance'];
                    if ($type == 1) {
                        $q = "UPDATE `az_balance` SET `total_balance` = (`total_balance` + $balance ) WHERE routeid = '{$rows['routeid']}' AND userid = '{$id}'";
                    } else {
                        $q = "UPDATE `az_balance` SET `total_balance` = (`total_balance` - $balance ) WHERE routeid = '{$rows['routeid']}' AND userid = '{$id}'";
                    }
                    $res = mysqli_query($dbc, $q);
                }
                return true;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function getUserGateway() {
        global $dbc;
        $qry = "SELECT `service_id`, `az_rname` FROM `az_user_services` INNER JOIN `az_routetype` ON `az_user_services`.`service_id` = `az_routetype`.az_routeid WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[] = $rows;
            }
        }
        return $out;
    }

    function switchUserGateway() {
        global $dbc;
        $q = "SELECT count(*) tot FROM `az_user_services` WHERE service_id = '{$_GET['from_gateway']}' AND userid = '{$_GET['userid']}'";
        $rs = mysqli_query($dbc, $q);
        $data = mysqli_fetch_assoc($rs);
        if ($data['tot'] == 0) {
            return 'gatewayNotAssign';
            exit;
        }
        if (isset($_GET['userid']) && !empty($_GET['userid'])) {
            $ids = $this->getUserCredit($_GET['userid']);
            if (!empty($ids)) {
                $ids = implode(',', $ids) . ',' . $_GET['userid'];
                $cond = " userid IN($ids)";
            } else {
                $cond = " userid = '{$_GET['userid']}'";
            }
            echo $q = "UPDATE `az_user_services` SET `service_id` = '{$_GET['to_gateway']}' WHERE $cond";
        }
    }

    function filterAssignCredit($start = null, $end = null) {
        global $dbc;
        $cond = 'WHERE 1 ';
        $limit = '';
        if ($_SESSION['user_id'] != 1) {
            $cond .= " AND CRMG.userid = {$_SESSION['user_id']}";
        }
        if (isset($_POST['userid']) && !empty($_POST['userid'])) {
            $cond .= " AND customer_id = {$_POST['userid']}";
        }
        if (isset($_POST['az_routeid']) && !empty($_POST['az_routeid'])) {
            $cond .= " AND az_routeid = {$_POST['az_routeid']}";
        }

        $today = date('Ymd');
        $ydate = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " -1 day");
        $ydate = date('Y-m-d', $ydate);
        if (isset($_POST['searchtype']) && !empty($_POST['searchtype'])) {
            $searctype = $_POST['searchtype'];
            if ($searctype == 1) {
                $cond .= " AND CRMG.`created` BETWEEN '" . date("Y-m-d") . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
            } else if ($searctype == 2) {
                $cond .= " AND CRMG.`created` BETWEEN '" . $ydate . " 00:00:00' AND '" . $ydate . " 23:59:59'";
            } else if ($searctype == 3) {
                $lstweek = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " -7 day");
                $lstweek = date('Y-m-d', $lstweek);
                $cond .= " AND CRMG.`created` BETWEEN '" . $lstweek . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
            } else if ($searctype == 4) {
                $fifteen = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " -15 day");
                $fifteen = date('Y-m-d', $fifteen);
                $cond .= " AND CRMG.`created` BETWEEN '" . $fifteen . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
            } else if ($searctype == 5) {
                $lstmnt = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " -30 day");
                $lstmnt = date('Y-m-d', $lstmnt);
                $cond .= " AND CRMG.`created` BETWEEN '" . $lstmnt . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
            } else if ($searctype == 6) {
                $datestr = $this->DateFormate($_POST['specific']);
                $cond .= " AND CRMG.`created` BETWEEN '" . $datestr . " 00:00:00' AND '" . $datestr . " 23:59:59'";
            } else if ($searctype == 7) {
                $from = $this->DateFormate($_POST['cust_from']);
                $to = $this->DateFormate($_POST['cust_to']);
                $cond .= " AND CRMG.`created` BETWEEN '" . $from . " 00:00:00' AND '" . $to . " 23:59:59'";
            }
        }
        $qry = "SELECT count(*) as tot FROM `az_credit_manage` CRMG INNER JOIN az_routetype USING(az_routeid) $cond";
        $rs1 = mysqli_query($dbc, $qry);
        $data = mysqli_fetch_assoc($rs1);
        $tot = $data['tot'];
        $limit = " LIMIT  $start, $end";
        $q = "SELECT CRMG.*, az_routetype.az_rname, user_name FROM `az_credit_manage` CRMG INNER JOIN az_routetype USING(az_routeid) INNER JOIN az_user USER ON USER.userid = CRMG.`customer_id` $cond ORDER BY CRMG.created DESC $limit";
        $result = mysqli_query($dbc, $q);
        $out = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $out[$row['crmid']] = $row;
        }
        return array('result' => $out, 'count' => $tot);
    }

    function getUsername() {
        global $dbc;
        $cond = 'WHERE 1 ';
        if ($_SESSION['user_id'] != 1) {
            $cond .= " AND parent_id = {$_SESSION['user_id']}";
        }
        $q = "SELECT userid, user_name FROM az_user $cond";
        $rs = mysqli_query($dbc, $q);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[] = $rows;
            }
        }
        return $out;
    }

    function DateFormate($date) {
        if (!empty($date)) {
            $rs = explode('/', $date);
            return $str = $rs[2] . '-' . $rs[0] . '-' . $rs[1];
        } else {
            return false;
        }
    }

    function DateFormateMDY($date) {
        if (!empty($date)) {
            $rs = explode('/', $date);
            return $str = $rs[2] . '-' . $rs[1] . '-' . $rs[0];
        } else {
            return false;
        }
    }

    function getAssignRoute($uid = null, $userid = null) {
        global $dbc;
        $out = array();
        $cond = 'WHERE 1';
        if (!empty($uid)) {
            $cond .= " AND az_routeid = $uid";
        }
        if (!empty($userid)) {
            $cond .= " AND userid  = '{$userid}'";
        }
        if ($userid == '') {
            $cond .= " AND userid  = {$_SESSION[$_POST['csess']]['id']}";
        }
        $q = "SELECT az_routeid, az_rname, `az_issenderid`, az_gateway_name FROM `az_balance` INNER JOIN `az_routetype` ON `az_balance`.routeid = `az_routetype`.az_routeid $cond  ORDER BY `az_routeid` ASC ";
        $rs = mysqli_query($dbc, $q);
        $route_out = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['az_routeid'];
            $route_out[$id]['az_routeid'] = $row['az_routeid'];
            $route_out[$id]['az_rname'] = $row['az_rname'];
            $route_out[$id]['az_issenderid'] = $row['az_issenderid'];
            $route_out[$id]['service_name'] = $row['az_gateway_name'];
        }
        return $route_out;
    }

    function getLowPriceData($userid = null, $routeid = null) {

        global $dbc;

        $cond = "WHERE 1 ";
        if (isset($_POST['userid']) && !empty($_POST['userid'])) {
            $cond .= " AND userid = {$_POST['userid']}";
        }
        if (isset($_GET['userid']) && !empty($_GET['userid'])) {
            $cond .= " AND userid = {$_GET['userid']}";
        }
        if (isset($userid) && !empty($userid)) {
            $cond .= " AND userid = {$userid}";
        }
        if (isset($routeid) && !empty($routeid)) {
            $cond .= " AND routeid = {$routeid}";
        }
        $qry = "SELECT id, routeid, is_low, start_from, low_price_per FROM `az_low_price` $cond";
        $rs = mysqli_query($dbc, $qry);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out[$rows['id']] = $rows;
            }
        }
        return $out;
    }

    function LserviceSaveData() {
        global $dbc;
        if ($_SESSION['user_id'] == 1) {
            if ($_POST['parent_id'] != $_SESSION['user_id']) {
                echo 3;
                exit;
            }
        }
        $lowsdata = $this->getLowPriceData();
        $users = $this->getUserCredit($_POST['userid']);
        array_push($users, $_POST['userid']);

        if (empty($lowsdata)) {
            $currlevel = 1;
            $currlevelbyassignuser = 0;
        }
        $userids = implode(',', $users);

        $qry = "DELETE FROM `az_low_price` WHERE `userid` IN($userids) AND parent_id = {$_POST['parent_id']}";
        $result = mysqli_query($dbc, $qry);

        if ($result) {
            $currlevelbyassignuser = $this->getUserCurrentLevel($_SESSION['user_id']);

            if (isset($_POST['routeid']) && !empty($_POST['routeid'])) {
                foreach ($_POST['routeid'] as $key => $routeid) {
                    $is_low = isset($_POST['is_low'][$key]) && $_POST['is_low'][$key] ? $_POST['is_low'][$key] : 0;

                    foreach ($users as $uid) {
                        if ($this->checkGateway($uid, $routeid)) {
                            $currlevel = $this->getUserCurrentLevel($uid);
                            $qrystr[] = '(NULL, ' . $_SESSION['user_id'] . ', ' . $uid . ', ' . $currlevel . ', ' . $currlevelbyassignuser . ', ' . $routeid . ', ' . $is_low . ', ' . $_POST['start_from'][$key] . ', ' . $_POST['low_price_per'][$key] . ', NOW())';
                        }
                    }
                }
            }

            if (!empty($qrystr)) {
                $qry_1 = "INSERT INTO `az_low_price`(`id`, `parent_id`, `userid`, `current_level`, `level_of_assign_user`, `routeid`, `is_low`, `start_from`, `low_price_per`, `crdate`) VALUES" . implode(', ', $qrystr);
                $res_1 = mysqli_query($dbc, $qry_1);
                echo ($res_1 != false) ? 1 : 0;
                exit;
            }
        } else {
            echo 1;
            exit;
        }
    }

    function getUserCurrentLevel($userid) {
        global $dbc;
        $q = "SELECT `user_level` FROM `az_user` WHERE userid = {$userid}";
        $rs = mysqli_query($dbc, $q);
        $rows = mysqli_fetch_assoc($rs);
        return $rows['user_level'];
    }

    function checkGateway($userid, $routeid) {
        global $dbc;
        $q = "SELECT COUNT(1) AS tot FROM `az_balance` WHERE userid = {$userid} AND routeid = {$routeid}";
        $rs = mysqli_query($dbc, $q);
        $rows = mysqli_fetch_assoc($rs);
        return $rows['tot'] > 0 ? true : false;
    }

    function saveLowPriceData() {
        global $dbc;
        if (isset($_POST['userid']) && $_POST['userid'] != "") {
            $qry = "DELETE FROM `az_low_price` WHERE `userid` = '{$_POST['userid']}'";
            $result = mysqli_query($dbc, $qry);
            if ($result) {
                $qrystr = array();
                foreach ($_POST['routeid'] as $key => $routeid) {
                    if ($routeid == '') {
                        echo 'Select Routeid';
                        exit;
                    }
                    $is_low = isset($_POST['is_low'][$key]) && $_POST['is_low'][$key] ? $_POST['is_low'][$key] : 0;
                    $qrystr[] = '(NULL, ' . $_POST['userid'] . ', ' . $routeid . ', ' . $is_low . ', ' . $_POST['start_from'][$key] . ', ' . $_POST['low_price_per'][$key] . ')';
                }
                if (!empty($qrystr)) {
                    echo $rs1 = mysqli_query($dbc, "INSERT INTO `az_low_price` (`id`, `userid`, `routeid`, `is_low`, `start_from`, `low_price_per`) VALUES" . implode(', ', $qrystr));
                    echo $rs1 == true ? 1 : 0;
                }
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    function checkLowPrice($userid, $routedata) {
        global $dbc;
        if ((isset($userid) && $userid != "") && (isset($routedata) && !empty($routedata))) {
            $qry = "SELECT id, routeid, is_low, start_from, low_price_per FROM `az_low_price` WHERE userid = {$_SESSION['user_id']}";
            $rs = mysqli_query($dbc, $qry);
            $out = array();
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $out[$rows['id']] = $rows;
                    if (in_array($rows['routeid'], $routedata)) {
                        $is_low = isset($rows['is_low']) && $rows['is_low'] ? $rows['is_low'] : 0;
                        $qrystr[] = '(NULL, ' . $userid . ', ' . $rows['routeid'] . ', ' . $is_low . ', ' . $rows['start_from'] . ', ' . $rows['low_price_per'] . ')';
                    }
                }
                if (!empty($qrystr)) {
                    $qry_1 = "INSERT INTO `az_low_price` (`id`, `userid`, `routeid`, `is_low`, `start_from`, `low_price_per`) VALUES" . implode(', ', $qrystr);
                    $res_1 = mysqli_query($dbc, $qry_1);
                    return ($res_1 != false) ? 1 : false;
                }
            }
            return true;
        }
    }

    function getSenderidListing($start = null, $end = null) {
        global $dbc;
        $cond = "WHERE 1  ";
        if ($_SESSION['user_id'] != 1) {
            $cond .= "  AND parent_id != 0";
            $cond .= "  AND parent_id = {$_SESSION['user_id']}";
        }
        if (isset($_POST['sid']) && !empty($_POST['sid'])) {
            $cond .= " AND sid = '{$_POST['sid']}'";
        }
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $cond .= " AND user_name = '{$_POST['username']}'";
        }
        if (isset($_POST['senderidserch']) && !empty($_POST['senderidserch'])) {
            $cond .= " AND senderid = '{$_POST['senderidserch']}'";
        }
        $limit = isset($start) && isset($start) ? " LIMIT  $start, $end" : '';
        $qry = "SELECT COUNT(*) as tot FROM az_senderid SNDR INNER JOIN az_user USR USING(userid) $cond";
        $rs_count = mysqli_query($dbc, $qry);
        $countRows = mysqli_fetch_assoc($rs_count);
        $count = $countRows['tot'];

        $q = "SELECT sid, SNDR.userid, SNDR.senderid, SNDR.descript, SNDR.status, USR.user_name, SNDR.created_at FROM az_senderid SNDR INNER JOIN az_user USR USING(userid) $cond  ORDER BY created_at DESC $limit";
        $rs = mysqli_query($dbc, $q);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $id = $row['sid'];
                $out[$id] = $row;
            }
        }
        mysqli_free_result($rs);
        return array('result' => $out, 'count' => $count);
    }

    function saveSenderid() {
        global $dbc;
        $q = "SELECT senderid FROM az_senderid WHERE userid = '" . $_POST['userid'] . "' AND senderid = '" . $_POST['senderid'] . "'";
        $rs = mysqli_query($dbc, $q);
        if (mysqli_num_rows($rs) > 0) {
            return 2;
        }
        $status = 0;
        if (isset($_SESSION['OpnSndr']) && $_SESSION['OpnSndr'] == 'OpnSndr') {
            $managerObj = new managermanagement();
            $result = $managerObj->checkUserGateway();
            if ($result == true) {
                $status = 1;
            }
        }
        $sql = "INSERT INTO az_senderid(`sid`, `userid`, `senderid`, `descript`, `created_at`, `status`) VALUES(NULL, '" . $_POST['userid'] . "','" . $_POST['senderid'] . "','" . $_POST['descript'] . "', NOW(), '" . $status . "')";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return 1;
        else
            return 0;
    }

    function updateSenderid() {
        global $dbc;
        $sql = "UPDATE az_senderid SET userid = '{$_POST['userid']}', senderid = '{$_POST['senderid']}',descript = '{$_POST['descript']}', gatewayid =  '{$gatewayid}', set_as_priority =  '{$set_as_priority}' WHERE sid = {$_POST['sid']}";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return 1;
        else
            return 0;
    }

    function deleteSenderid() {
        global $dbc;
        $sql = "DELETE FROM az_senderid WHERE sid = {$_POST['sid']}";
        $res = mysqli_query($dbc, $sql);
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }

    function getUsersGateway() {
        global $dbc;
        $out = array();
        if (isset($_GET['userid']) && $_GET['userid'] != '') {
            $Qry = "SELECT az_routeid, az_rname, total_balance, current_price, new_price FROM az_balance BAL INNER JOIN az_routetype ROT ON BAL.routeid = ROT.az_routeid WHERE userid = {$_GET['userid']}";
            $rs = mysqli_query($dbc, $Qry);
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $out[] = $rows;
                }
            }
        }
        return $out;
    }

    function saveUserGatewayFun() {
        global $dbc;
        if (isset($_POST['userid']) && !empty($_POST['userid'])) {
            $userid = $_POST['userid'];
            $user_role = $this->getUserRoleByUserid($userid);

            if ($user_role == 2) {
                foreach ($_POST['az_routeid'] as $key => $routeid) {
                    if ($_POST['current_price'][$key] != '' && $_POST['new_price'][$key] != '') {

                        $sms_price = $_POST['current_price'][$key];
                        $new_sms_price = $_POST['new_price'][$key];
                        $total_balance = $this->getBalanceByUseridAndRouteid($userid, $routeid);
                        $bid = $this->getBalanceByUseridAndRouteid($userid, $routeid);
                        $new_total_balance = ceil(($total_balance * $sms_price) / $new_sms_price);
                        $balance_diff = $total_balance - $new_total_balance;

                        $res_1 = mysqli_query($dbc, "INSERT INTO `az_manage_credit_log`(`id`, `bid`, `userid`, `routeid`, `before_total_balance`,`after_total_balance`, `balance_diff`,`before_sms_price`,`after_sms_price`,  `updated_date`) VALUES (NULL, " . $bid . ", '" . $userid . "', '" . $routeid . "', '" . $total_balance . "','" . $new_total_balance . "','" . $balance_diff . "', '" . $sms_price . "','" . $new_sms_price . "', NOW())");

                        $res_2 = mysqli_query($dbc, "INSERT INTO `az_credit_manage`(`crmid`, `userid`, `customer_id`, `az_routeid`, `assign_credit`, `debit_credit`, `balance`, `credit_mode`, `account_manager`, `remark`, `credit_date`, `created`) VALUES (NULL, '{$_SESSION['user_id']}', '{$userid}', '{$routeid}', '0', '$balance_diff', '0', '2', '', 'Debited At The Time of Credit Updation', NOW(), NOW())");


                        $qry = "UPDATE az_balance SET `current_price` = '{$sms_price}', `new_price` = '{$new_sms_price}', `total_balance` = '" . $new_total_balance . "' WHERE userid = {$userid} AND routeid = {$routeid}";
                        $rs = mysqli_query($dbc, $qry);
                    } else {
                        return array('status' => 0, 'msg' => 'Enter your price');
                    }
                }
                $rs1 = mysqli_query($dbc, "UPDATE az_user SET `price_status` = 1 WHERE userid = {$userid}");
            }

            if ($user_role == 1) {
                $ids = $this->getUserCredit($userid);
                if (!empty($ids)) {
                    $ids = implode(',', $ids) . ',' . $userid;
                } else {
                    $ids = $userid;
                }

                $Qry = "SELECT * FROM `az_balance` WHERE `userid` IN ({$ids})";
                $res = mysqli_query($dbc, $Qry);
                while ($row = mysqli_fetch_assoc($res)) {
                    foreach ($_POST['az_routeid'] as $key => $routeid) {
                        if ($_POST['current_price'][$key] != '' && $_POST['new_price'][$key] != '') {
                            if ($routeid == $row['routeid']) {

                                $sms_price = $_POST['current_price'][$key];
                                $new_sms_price = $_POST['new_price'][$key];
                                $total_balance = $this->getBalanceByUseridAndRouteid($row['userid'], $routeid);
                                $bid = $this->getBidByUseridAndRouteid($row['userid'], $routeid);
                                $new_total_balance = ceil(($total_balance * $sms_price) / $new_sms_price);
                                $balance_diff = $total_balance - $new_total_balance;

                                $res_1 = mysqli_query($dbc, "INSERT INTO `az_manage_credit_log`(`id`, `bid`, `userid`, `routeid`, `before_total_balance`,`after_total_balance`, `balance_diff`,`before_sms_price`,`after_sms_price`,  `updated_date`) VALUES (NULL, " . $bid . ", '" . $row['userid'] . "', '" . $routeid . "', '" . $total_balance . "','" . $new_total_balance . "','" . $balance_diff . "', '" . $sms_price . "','" . $new_sms_price . "', NOW())");

                                $res_2 = mysqli_query($dbc, "INSERT INTO `az_credit_manage`(`crmid`, `userid`, `customer_id`, `az_routeid`, `assign_credit`, `debit_credit`, `balance`, `credit_mode`, `account_manager`, `remark`, `credit_date`, `created`) VALUES (NULL, '{$_SESSION['user_id']}', '{$row['userid']}', '{$routeid}', '0', '$balance_diff', '0', '2', '', 'Debited At The Time of Credit Updation', NOW(), NOW())");


                                $qry = "UPDATE az_balance SET `current_price` = '{$sms_price}', `new_price` = '{$new_sms_price}', `total_balance` = '" . $new_total_balance . "' WHERE userid = {$row['userid']} AND routeid = {$routeid}";
                                $rs = mysqli_query($dbc, $qry);
                            }
                        } else {
                            return array('status' => 0, 'msg' => 'Enter your price');
                        }
                    }
                    $rs1 = mysqli_query($dbc, "UPDATE az_user SET `price_status` = 1 WHERE userid = {$row['userid']}");
                }
            }

            if ($rs && $rs1) {
                return array('status' => 1, 'msg' => 'New Price Updated');
            } else {
                return array('status' => 0, 'msg' => 'Error Occured');
            }
        }
    }

    function getGsersGatewayListFun($start = null, $end = null) {
        global $dbc;
        $cond = "WHERE 1  ";
        if ($_SESSION['user_id'] != 1) {
            $cond .= "  AND parent_id != 0";
            $cond .= "  AND parent_id = {$_SESSION['user_id']}";
        } else {
            $cond .= "  AND parent_id = {$_SESSION['user_id']}";
        }
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $cond .= " AND user_name = '{$_POST['username']}'";
        }
        if (isset($_POST['company']) && !empty($_POST['company'])) {
            $cond .= " AND company_name LIKE '{$_POST['company']}%'";
        }
        $limit = isset($start) && isset($start) ? " LIMIT  $start, $end" : '';
        $qry = "SELECT COUNT(1) as tot FROM az_user $cond";
        $rs_count = mysqli_query($dbc, $qry);
        $countRows = mysqli_fetch_assoc($rs_count);
        $count = $countRows['tot'];
        $q = "SELECT USR.userid, user_name, company_name FROM az_user USR $cond  ORDER BY user_name ASC $limit";
        $rs = mysqli_query($dbc, $q);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $id = $row['userid'];
                $out[$id]['user_name'] = $row['user_name'];
                $out[$id]['company_name'] = $row['company_name'];
                $out[$id]['gateways'] = $this->getUsersGatewayCredits($row['userid']);
            }
        }
        mysqli_free_result($rs);
        return array('result' => $out, 'count' => $count);
    }

    function getUsersGatewayCredits($userid) {
        global $dbc;
        $q = "SELECT az_routeid, az_rname, total_balance, current_price, new_price FROM az_balance BAL INNER JOIN az_routetype ROT ON BAL.routeid = ROT.az_routeid WHERE userid = {$userid}";
        $rs = mysqli_query($dbc, $q);
        $out = array();
        if (mysqli_num_rows($rs) > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $az_routeid = $row['az_routeid'];
                $out[$az_routeid]['az_rname'] = $row['az_rname'];
                $out[$az_routeid]['total_balance'] = $row['total_balance'];
                $out[$az_routeid]['current_price'] = $row['current_price'];
                $out[$az_routeid]['new_price'] = $row['new_price'];
                $debitbalance = 0;
                $newbalance = 0;
                if ($row['total_balance'] != '' && $row['current_price'] != '' && $row['new_price'] != '') {
                    $newbalance = ceil(($row['total_balance'] * $row['current_price']) / $row['new_price']);
                    $debitbalance = $row['total_balance'] - $newbalance;
                }
                $out[$az_routeid]['debitbalance'] = $debitbalance;
                $out[$az_routeid]['newbalance'] = $newbalance;
            }
        }
        mysqli_free_result($rs);
        return $out;
    }

    function getUserRoleByUserid($userid) {
        global $dbc;
        $qry = "SELECT `user_role` FROM `az_user` WHERE `userid` = '{$userid}' LIMIT 1;";
        $rs = mysqli_query($dbc, $qry);
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['user_role'];
        }
        return $out;
    }

    function getBalanceByUseridAndRouteid($userid, $routeid) {
        global $dbc;
        $qry = "SELECT `total_balance` FROM `az_balance` WHERE `userid` = '{$userid}' AND `routeid` = '{$routeid}' LIMIT 1;";
        $rs = mysqli_query($dbc, $qry);
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['total_balance'];
        }
        return $out;
    }

    function getBidByUseridAndRouteid($userid, $routeid) {
        global $dbc;
        $qry = "SELECT `bid` FROM `az_balance` WHERE `userid` = '{$userid}' AND `routeid` = '{$routeid}' LIMIT 1;";
        $rs = mysqli_query($dbc, $qry);
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            $out = $rows['bid'];
        }
        return $out;
    }

    // Encrypt Function Added by Azizur 22-01-2021
    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = date('Y-m-d') . 'MDSMedia@key';
        $secret_iv = date('Y-m-d') . 'MDSMedia@iv';

        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == '1') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == '2') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}

// End Class
?>


