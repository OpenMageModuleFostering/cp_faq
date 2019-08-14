<?php
class CP_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Frequently Asked Questions"));
	   $this->renderLayout();
    }
     public function editAction()
    {
        $faqId     = $this->getRequest()->getParam('id');
        $faqModel  = Mage::getModel('faq/faq')->load($faqId);
 
        if ($faqModel->getId() || $faqId == 0) {
 
            Mage::register('faq_data', $faqModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('faq/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('faq/adminhtml_faq_edit'))
                 ->_addLeft($this->getLayout()->createBlock('faq/adminhtml_faq_edit_tabs'));
               
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
                $faqModel = Mage::getModel('faq/faq');
               //echo '<pre>'; print_r($postData); exit;
                $faqModel->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setDescription($postData['description'])
                    ->setFaqCategoryId($postData['faq_category_id'])
                    ->setStatus($postData['status'])
                    ->setIsFaq($postData['is_faq'])
                    ->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Faq was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setfaqData(false);
 
                
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFaqData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            if($postData['username'] != '' && $postData['status'] == 1)
                {
                    
                //Email send to admin 
                $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('reply_create_faq_by_customer_template'); 
            $faq_cat_identifier = Mage::getModel('faq/category')->load($postData['faq_category_id'])->getIdentifier();
            $faq_cat = Mage::getModel('faq/category')->load($postData['faq_category_id'])->getName();
            $emailTemplateVariables = array();
            $emailTemplateVariables['username'] = $postData['username'];
            $emailTemplateVariables['useremail'] = $postData['useremail'];
            $emailTemplateVariables['title'] = $postData['title'];
            $emailTemplateVariables['faq_category_name'] = $faq_cat;
            $emailTemplateVariables['description'] = $postData['description']; 
            $emailTemplateVariables['faq_cat_identifier'] = $faq_cat_identifier;
            $emailTemplateVariables['status'] = $postData['status'];
            
            $from_email = Mage::getStoreConfig('trans_email/ident_general/email');
            $from_name = Mage::getStoreConfig('trans_email/ident_general/name'); 
            
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
            $mail = Mage::getModel('core/email')
                                ->setToName($postData['username'])
                                ->setToEmail($postData['useremail'])
                                ->setBody($processedTemplate)
                                ->setSubject('FAQ reply')
                                ->setFromEmail($from_email)
                                ->setFromName($from_name)
                                ->setType('html');
            try{
                $mail->send();
                $this->_redirect('*/*/');
                return;
            }
            catch(Exception $error)
            {
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }   
           }
            // Email send code End
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $faqModel = Mage::getModel('faq/faq');
               
                $faqModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Faq was successfully deleted'));
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
               $this->getLayout()->createBlock('faq/adminhtml_faq_grid')->toHtml()
        );
    }
}