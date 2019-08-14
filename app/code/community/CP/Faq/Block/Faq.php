<?php   
class CP_Faq_Block_Faq extends Mage_Core_Block_Template{   

protected $_faqCollection;
    
    
    public function getCategoryCollection()
    {
         $this->_categoryCollection = Mage::getModel('faq/category')
                                ->getCollection()
                                ->distinct(true)
                                ->addFieldToFilter('status','1');
         
         
         return $this->_categoryCollection;
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        $_pageAvailableLimit = array(4=>4,6=>6,10=>10,all=>all);
        $pager = $this->getLayout()
            ->createBlock('page/html_pager', 'my.pager');
        $pager->setAvailableLimit($_pageAvailableLimit);
        $pager->setCollection($this->getMyCollection());
        
        $this->setChild('pager', $pager);
        $this->getMyCollection()->load();
        
    }
    
    protected function getMyCollection()
    {
        if (is_null($this->_myCollection)) {
            
            $this->_myCollection = Mage::getModel('faq/faq')
                                ->getCollection()
                                ->distinct(true)
                                ->addFilter('status','1');
         $current_catid = $this->getRequest()->getParam('category_id');
         
         // get identifier from faq_category table
         $ident = Mage::getModel('faq/category')
                            ->getCollection()
                            ->addFieldToFilter('identifier',$current_catid)
                            ->addFieldToSelect('faq_cat_id')
                            ->getData();
         
         $cat_id_from_tbl = $ident[0]['faq_cat_id'];
         
         if($current_catid)
         {
             $this->_myCollection->addFieldToFilter('faq_category_id', $cat_id_from_tbl);
         }
       $mfaq = $this->getRequest()->getParam(0); 
      if($mfaq == 'mfaq')
      {
            $this->_myCollection->addFieldToFilter('is_faq', 1);
      }
        }

        return $this->_myCollection;
    }
    
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    
    public function getCatName($cat_id)
    {
        
        $catname = Mage::getModel('faq/category')->getCollection()->AddFieldToFilter('identifier',$cat_id)->AddFieldToSelect('name')->getData();
        return($catname[0]['name']);
    }

   



}