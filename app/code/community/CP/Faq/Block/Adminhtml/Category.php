<?php  

class CP_Faq_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'faq';
        $this->_headerText = Mage::helper('faq')->__('Manage Faq Category');
        $this->_addButtonLabel = Mage::helper('faq')->__('Add Faq Category');
        parent::__construct();
    }

}