<?php



class CP_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set defaults
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faqGrid');
        $this->setDefaultSort('faq_id');
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
        $collection = Mage::getModel('faq/faq')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();

    }
    /**
     * Define grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'faq_id', 
            array(
                'header'=> Mage::helper('faq')->__('ID'),
                'type'  => 'number',
                'width' => '1',
                'index' => 'faq_id',
            )
        );

        $this->addColumn(
            'title', 
            array(
                'header' => Mage::helper('faq')->__('FAQ Title'),
                'index'  => 'title',
            )
        );
        
         $this->addColumn(
            'Faq Category', 
            array(
                'header' => Mage::helper('faq')->__('FAQ Category'),
                'index'  => 'faq_category_id',
                'renderer'  => 'faq/adminhtml_widget_grid_column_renderer_category',
            )
        );
            
       /* $this->addColumn(
            'Most Frequently', 
            array(
                'header' => Mage::helper('faq')->__('Most Frequently'),
                'index'  => 'is_faq',
                'type'    => 'options',
                'options' =>
                    array(
                        CP_Faq_Model_Status::STATUS_ENABLED  => Mage::helper('faq')->__('Yes'),
                        CP_Faq_Model_Status::STATUS_DISABLED => Mage::helper('faq')->__('No'),
                    ),
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
                //'options' => Mage::getModel('faq/status')->getAllOptions(),
                'options' =>
                    array(
                        CP_Faq_Model_Status::STATUS_ENABLED  => Mage::helper('faq')->__('Yes'),
                        CP_Faq_Model_Status::STATUS_DISABLED => Mage::helper('faq')->__('No'),
                    ),
            )
        );*/
        $this->addColumn(
            'Status', 
            array(
                'header' => Mage::helper('faq')->__('Status'),
                'index'  => 'status',
                'type'    => 'options',
                'options' =>
                    array(
                        CP_Faq_Model_Status::STATUS_ENABLED  => Mage::helper('faq')->__('Active'),
                        CP_Faq_Model_Status::STATUS_DISABLED => Mage::helper('faq')->__('Inactive'),
                    ),
            )
        );

       /* $this->addColumn(
            'faq_category', 
            array(
                'header' => Mage::helper('zeon_faq')->__('FAQ Category'),
                'type'   => 'text',
                'index'  => 'category_name',
            )
        );

        $this->addColumn(
            'is_most_frequently', 
            array(
                'header' => Mage::helper('zeon_faq')->__('Most Frequently'),
                'index'  => 'is_most_frequently',
                'type'    => 'options',
                'options' =>
                    array(
                        Zeon_Faq_Model_Status::STATUS_ENABLED  => Mage::helper('zeon_faq')->__('Yes'),
                        Zeon_Faq_Model_Status::STATUS_DISABLED => Mage::helper('zeon_faq')->__('No'),
                    ),
            )
        );

        $this->addColumn(
            'update_time', 
            array(
                'header'=> Mage::helper('zeon_faq')->__('Last Updated'),
                'type' => 'datetime',
                'index'=> 'update_time',
            )
        );

        $this->addColumn(
            'status', 
            array(
                'header'  => Mage::helper('zeon_faq')->__('Status'),
                'align'   => 'center',
                'width'   => 1,
                'index'   => 'status',
                'type'    => 'options',
                'options' => Mage::getModel('zeon_faq/status')->getAllOptions(),
            )
        );


        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn(
                'visible_in', 
                array(
                    'header'     => Mage::helper('zeon_faq')->__('Visible In'),
                    'type'       => 'store',
                    'index'      => 'stores',
                    'sortable'   => false,
                    'store_view' => true,
                    'width'      => 200
                )
            );
            
        }
*/
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