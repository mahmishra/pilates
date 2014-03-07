<?php

/**
 * This class is used to process business
 * 
 * @author Gema Megantara <gema@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
include_once '../core/action.php';

define('EBIZU_MODULE_ACTION', 'Products');

class Products extends Action {

    /**
     * Method used to process action
     * @return void
     */
    public function process() {
        $result = "here";
         $this->setResult(Ebizu::success((object) $result));
    }

    public function validate() {
        return true;
    }

}

?>
