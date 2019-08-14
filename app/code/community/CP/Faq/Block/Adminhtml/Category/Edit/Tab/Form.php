<?php
 
class CP_Faq_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('category_form', array('legend'=>Mage::helper('faq')->__('Faq Category information')));
       
        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('faq')->__('Category Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name',
        ));
 
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('faq')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('faq')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('faq')->__('Inactive'),
                ),
            ),
        ));
        
        
        if ( Mage::getSingleton('adminhtml/session')->getCategoryData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCategoryData());
            Mage::getSingleton('adminhtml/session')->setCategoryData(null);
        } elseif ( Mage::registry('category_data') ) {
            $form->setValues(Mage::registry('category_data')->getData());
        }
        return parent::_prepareForm();
    }
}
?>