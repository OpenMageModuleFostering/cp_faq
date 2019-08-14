<?php   
class CP_Faq_Block_Category extends Mage_Core_Block_Template{   

    public function getCategoryCollection()
    {
         $this->_categoryCollection = Mage::getModel('faq/category')
                                ->getCollection()
                                ->distinct(true)
                                ->addFieldToFilter('status','1');
         
         
         return $this->_categoryCollection;
    }
    public function isActiveCategory($category)
    {
        $current_catid = $this->getRequest()->getParam('category_id');
        
        if($category->getData('faq_cat_id') == $current_catid)
        {
            return true;
            
        }
        else
        {
            return false;
            
        }
    }
    
    public function getmfaqCollection()
    {
        $this->_mfaqCollection = Mage::getModel('faq/faq')
                                ->getCollection()
                                ->distinct(true)
                                ->addFilter('is_faq','1')
                                ->addFilter('status','1');        
         
         return $this->_mfaqCollection;
    }

}