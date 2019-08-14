<?php
class CP_Faq_Block_Adminhtml_Widget_Grid_Column_Renderer_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if($row->getFaqCategoryId()){
            $cat = Mage::getModel('faq/category')->load($row->getFaqCategoryId());
            return $cat->getName();
        }                     
    }
}
