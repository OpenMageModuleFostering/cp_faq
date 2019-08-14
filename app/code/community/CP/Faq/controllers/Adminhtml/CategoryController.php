<?php
class CP_Faq_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("FAQ Categories"));
	   $this->renderLayout();
    }
     public function editAction()
    {
        $faqId     = $this->getRequest()->getParam('id');
        $faqModel  = Mage::getModel('faq/category')->load($faqId);
 
        if ($faqModel->getId() || $faqId == 0) {
 
            Mage::register('category_data', $faqModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('category/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('faq/adminhtml_category_edit'))
                 ->_addLeft($this->getLayout()->createBlock('faq/adminhtml_category_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('faq')->__('Faq does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction()
    {
        $this->_forward('edit');
    }
   
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $faqModel = Mage::getModel('faq/category');
               
               
               $ident = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "_", $postData['name']));
               
               //echo $ident; exit;
                $faqModel->setId($this->getRequest()->getParam('id'))
                    ->setName($postData['name'])
                    ->setStatus($postData['status'])
                    ->setIdentifier($ident)
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Faq Category was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setcategoryData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCategoryData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $faqModel = Mage::getModel('faq/category');
               
                $faqModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Faq Category was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('faq/adminhtml_category_grid')->toHtml()
        );
    }
}