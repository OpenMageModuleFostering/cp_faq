<?php
 
class CP_Faq_Model_Category extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('faq/category');
    }
    
    public function getCategories() {

        $statesArray = array();
        foreach($this->getCollection() as $state){
            $statesArray[$state->getfaq_cat_id()] = $state->getName();

        }
        
        return $statesArray;

    }
}
?>