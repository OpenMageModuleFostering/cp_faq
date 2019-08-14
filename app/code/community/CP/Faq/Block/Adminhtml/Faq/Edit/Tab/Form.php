<?php
 
class CP_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('faq_form', array('legend'=>Mage::helper('faq')->__('Faq information')));
               
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('faq')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
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
        
        $fieldset->addField('is_faq', 'select', array(
            'label'     => Mage::helper('faq')->__('Is Most Frequently Asked Question'),
            'name'      => 'is_faq',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('faq')->__('Yes'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('faq')->__('No'),
                ),
            ),
        ));
        
        $fieldset->addField('username', 'text', array(
            'label'     => Mage::helper('faq')->__('Name'),
            'class'     => 'required-entry',
            'name'      => 'username',
            'readonly'  => 'readonly',
        ));

        $fieldset->addField('useremail', 'text', array(
            'label'     => Mage::helper('faq')->__('Email'),
            'class'     => 'required-entry',
            'name'      => 'useremail',
            'readonly'  => 'readonly',
        ));
                
        $fieldset->addField('faq_category_id', 'select', array(
            'label'     => Mage::helper('faq')->__('Faq Category'),
            'name'      => 'faq_category_id',
            'values'    => Mage::getModel('faq/category')->getCategories(),
        ));
        
       
        $fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('faq')->__('Description'),
            'title'     => Mage::helper('faq')->__('Description'),
            'style'     => 'width:98%; height:400px;',
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg'   => true,
            'required'  => true,
        ));
       
        if ( Mage::getSingleton('adminhtml/session')->getFaqData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getFaqData());
            Mage::getSingleton('adminhtml/session')->setFaqData(null);
        } elseif ( Mage::registry('faq_data') ) {
            $form->setValues(Mage::registry('faq_data')->getData());
        }
        return parent::_prepareForm();
    }
}
?>