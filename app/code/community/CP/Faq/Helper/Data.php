<?php
class CP_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Retrieve Faq URL
     *
     * @return string
     */
    public function getFaqUrl()
    {
        return $this->_getUrl('faq');
    }
}
	 