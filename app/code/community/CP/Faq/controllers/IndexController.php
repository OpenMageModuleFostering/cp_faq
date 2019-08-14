<?php
class CP_Faq_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction() {
      $this->loadLayout();   
	  $this->renderLayout(); 
    }
    
    public function addfaqAction()
    {
      
      if($this->getRequest()->getPost())  
      {
          $username = $this->getRequest()->getParam('username');
          $useremail = $this->getRequest()->getParam('useremail');
          $question = $this->getRequest()->getParam('question');
          //$ques_desc = $this->getRequest()->getParam('ques_desc');
          $drp_category = $this->getRequest()->getParam('drp_category');
          if(!$drp_category)
          $mostFaqAskd = 1;
          $faqmodel = Mage::getModel('faq/faq');
          $data = array('title'=>$question ,
                        'faq_category_id'=>$drp_category,
                        'is_faq'=>$mostFaqAskd,
                        'description'=>$ques_desc,
                        'username' => $username,
                        'useremail'=>$useremail,
                        'status'=>'0',
                        );

          $faqmodel->setData($data);
          $faqmodel->save();
          $faq_cat = Mage::getModel('faq/category')->load($drp_category)->getName();
          $faq_cat_identifier = Mage::getModel('faq/category')->load($drp_category)->getIdentifier();
          // Send email to CUSTOMER code started
            $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('create_faq_by_customer_template'); 
            $emailTemplateVariables = array();
            $emailTemplateVariables['username'] = $username;
            $emailTemplateVariables['useremail'] = $useremail;
            $emailTemplateVariables['title'] = $question;
            $emailTemplateVariables['faq_category_name'] = $faq_cat;
            $emailTemplateVariables['faq_cat_identifier'] = $faq_cat_identifier; 
            $from_email = Mage::getStoreConfig('trans_email/ident_general/email');
            $from_name = Mage::getStoreConfig('trans_email/ident_general/name'); 
            
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
            $mail = Mage::getModel('core/email')
                                ->setToName($username)
                                ->setToEmail($useremail)
                                ->setBody($processedTemplate)
                                ->setSubject('New Faq by customer')
                                ->setFromEmail($from_email)
                                ->setFromName($from_name)
                                ->setType('html');
            try{
                $mail->send();
            }
            catch(Exception $error)
            {
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }   
          // Send email to ADMIN code started
          $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('admin_create_faq_by_customer_template'); 
            $emailTemplateVariables = array();
            $emailTemplateVariables['username'] = $username;
            $emailTemplateVariables['useremail'] = $useremail;
            $emailTemplateVariables['title'] = $question;
            $emailTemplateVariables['faq_category_name'] = $faq_cat;
           // $emailTemplateVariables['description'] = $ques_desc; 
            $emailTemplateVariables['faq_cat_identifier'] = $faq_cat_identifier; 
            $from_email = Mage::getStoreConfig('trans_email/ident_general/email');
            $from_name = Mage::getStoreConfig('trans_email/ident_general/name'); 
            
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
            $mail1 = Mage::getModel('core/email')
                                ->setToName($from_name)
                                ->setToEmail($from_email)
                                ->setBody($processedTemplate)
                                ->setSubject('New Faq by customer')
                                ->setFromEmail($from_email)
                                ->setFromName($from_name)
                                ->setType('html');
            try{
                $mail1->send();
            }
            catch(Exception $error)
            {
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }   
           
            Mage::getSingleton('core/session')->addSuccess('Your question is saved. You will get email once admin approves your question.');
      }
      $this->loadLayout();   
      $this->renderLayout(); 
    }
}