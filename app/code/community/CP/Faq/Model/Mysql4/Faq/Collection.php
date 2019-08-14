<?php
 
class CP_Faq_Model_Mysql4_Faq_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('faq/faq');
    }
}
?>