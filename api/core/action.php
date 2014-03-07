<?php

/**
 * This class is used to manage action
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
class Action {

    private $module;

    /**
     * Method to get module
     * @return Object module
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * Method used to get database connection
     * @return PDO pdo object
     */
    public function getDB() {
        return $this->module->getDB();
    }

    /**
     * Method used to get request
     * @return Object request
     */
    public function getRequest() {
        return $this->getModule()->getRequest();
    }

    /**
     * Method used to get data
     * @return Object data
     */
    public function getData() {
        return $this->getModule()->getData();
    }

    /**
     * Method used to init action
     * @param array $module parameters
     * @return void
     */
    public function init($module) {
        $this->module = $module;
    }

    /**
     * Method used process action
     * @return void
     */
    public function process() {
        
    }

    /**
     * Method used to get customer id
     * @param String $company company ID
     * @return String customer ID
     */
    public function getCustomerId($company) {
        return $this->getModule()->getCustomerId($company);
    }
    
    /**
     * Method used to get customer id
     * @param String $company company ID
     * @return String customer ID
     */
    public function getBusinessCustomerId($member) {
        return $this->getModule()->getBusinessCustomerId($member);
    }

    /**
     * Method used to get user in session
     * @return Object user
     */
    public function getUser() {
        return $this->getModule()->getUser();
    }

    /**
     * Method used to get user App in session
     * @return Object userApp
     */
    public function getUserApp() {
        return $this->getModule()->getUserApp();
    }

    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isAuthorized() {
        return $this->module->isAuthorized();
    }
    
    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isBusinessAuthorized() {
        return $this->module->isBusinessAuthorized();
    }

    /**
     * Method used to check if current request is authorized
     * @return boolean true if authorized, else otherwise
     */
    public function isTabletAuthorized() {
        return $this->module->isTabletAuthorized();
    }

    /**
     * Method used to set result
     * @param type $result result
     */
    public function setResult($result) {
        $this->module->setResult($result);
    }

}

?>
