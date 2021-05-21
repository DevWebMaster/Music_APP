<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    public $_tablename = "tbl_customers";
    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email)
    {
        $this->db->select("email");
        $this->db->from($this->_tablename);
        $this->db->where("email", $email);
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function register($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     * @return user information or false if user is not matched
     */
    function login($email, $password)
    {
        $this->db->trans_start();

        $this->db->select('id, username, email, password, isLive, isDeleted, created_at, updated_at');
        $this->db->from($this->_tablename);
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();

        $user = $query->result();

        $this->db->trans_complete();

        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update($this->_tablename, $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('id, password');
        $this->db->where('id', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get($this->_tablename);
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update($this->_tablename, array('password' => $password));
        
        return $this->db->affected_rows();
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($email)
    {
        $this->db->select('*');
        $this->db->from('tbl_customers');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        $user = $query->result();
	   return $user;
    }

    function getProfile($email)
    {
        $this->db->select('*');
        $this->db->from('tbl_customers');
        $this->db->where('email', $email);
        $query = $this->db->get();
        
        return $query->result();
    }

    function setProfile($djsInfo, $email)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_customers', $djsInfo);
        
        return TRUE;
    }
    function getUserInfo1($email)
    {
        $this->db->select('*');
        $this->db->from('tbl_customers');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        $user = $query->result();
       return $user;
    }
    function deleteCustomerByEmail($email, $userinfo)
    {
        $this->db->where('email', $email);
        $this->db->update($this->_tablename, $userinfo);
        
        return $this->db->affected_rows();
    
    }

}

  