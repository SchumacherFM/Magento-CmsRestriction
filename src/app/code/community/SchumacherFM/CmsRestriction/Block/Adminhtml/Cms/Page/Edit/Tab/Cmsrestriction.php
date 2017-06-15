<?php
/**
 * @category    SchumacherFM_CmsRestriction
 * @package     Block
 * @author      Cyrill at Schumacher dot fm (@SchumacherFM)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @bugs        https://github.com/SchumacherFM/Magento-CmsRestriction/issues
 */
class SchumacherFM_CmsRestriction_Block_Adminhtml_Cms_Page_Edit_Tab_CmsRestriction extends Mage_Adminhtml_Block_Widget_Form implements
    Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * constructor
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * get list of store view ids the current page is assigned to
     *
     * @return array
     */
    public function getStoreViews()
    {
        $storeViews = $this->_getCurrentPageInstance()->getResource()->lookupStoreIds($this->_getCurrentPageInstance()->getId());
        return $storeViews;
    }

    /**
     * @return Mage_Cms_Model_Page
     */
    protected function _getCurrentPageInstance()
    {
        /* @var $model Mage_Cms_Model_Page */
        return Mage::registry('cms_page');
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $registry = $this->_getCurrentPageInstance();
        $allowedCustomerGroups = (strlen($registry->getAllowCustomerGroups()) > 0) ? explode(',', $registry->getAllowCustomerGroups()) : array();

        $fieldSet = $form->addFieldset('main_fieldset',
            array(

                'legend' => Mage::helper('schumacherfm_cmsrestriction')->__('Restrict to customer groups or individual customers')
            ));

        $fieldSet->addField('allow_customer_groups', 'multiselect',
            array(

                'name'     => 'allow_customer_groups[]',
                'label'    => Mage::helper('schumacherfm_cmsrestriction')->__('Allow Customer Groups'),
                'title'    => Mage::helper('schumacherfm_cmsrestriction')->__('Allow Customer Groups'),
                'required' => FALSE,
                'value'    => $allowedCustomerGroups,
                'values'   => Mage::getModel('schumacherfm_cmsrestriction/option_groups')->toOptionArray()
            ));

        $fieldSet->addField('allow_customer_ids', 'textarea', array(
            'label'              => Mage::helper('schumacherfm_cmsrestriction')->__('Allow Customer IDs'),
            'title'              => Mage::helper('schumacherfm_cmsrestriction')->__('Allow Customer IDs'),
            'name'               => 'allow_customer_ids',
            'style'              => 'height:10em;',
            'required'           => FALSE,
            'value'              => $registry->getAllowCustomerIds(),
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('schumacherfm_cmsrestriction')->__('Comma separated list with numbers.') . '</small></p>'
        ));

        return parent::_prepareForm();
    }

    /**
     * Return Tab label.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('schumacherfm_cmsrestriction')->__('CMS Restriction');
    }

    /**
     * Return Tab title.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('schumacherfm_cmsrestriction')->__('CMS Restriction');
    }

    /**
     * Can show tab in tabs.
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return TRUE;
    }

    /**
     * check if tab is hidden.
     *
     * @return boolean
     */
    public function isHidden()
    {
        return FALSE;
    }
}
