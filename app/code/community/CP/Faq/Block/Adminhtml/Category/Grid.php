<?php

class CP_Faq_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set defaults
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('faq_cat_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Instantiate and prepare collection
     *
     * @return Zeon_Faq_Block_Adminhtml_List_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('faq/category')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();

    }
    /**
     * Define grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'faq_cat_id', 
            array(
                'header'=> Mage::helper('faq')->__('ID'),
                'type'  => 'number',
                'width' => '1',
                'index' => 'faq_cat_id',
            )
        );

        $this->addColumn(
            'name', 
            array(
                'header' => Mage::helper('faq')->__('Category Name'),
                'index'  => 'name',
            )
        );
        
         $this->addColumn(
            'status', 
            array(
                'header'  => Mage::helper('faq')->__('Status'),
                'align'   => 'center',
                'width'   => 1,
                'index'   => 'status',
                'type'    => 'options',
                'options' => Mage::getModel('faq/status')->getAllOptions(),
            )
        );
      
        $this->addColumn(
            'action', 
            array(
                'header'  => Mage::helper('faq')->__('Action'),
                'width'   => '50',
                'type'    => 'action',
                'align'   => 'center',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('faq')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'action',
                'is_system' => true,
            )
        );

        return parent::_prepareColumns();
    }

   
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

   
   
}