<?php

class SchumacherFM_CmsRestriction_Model_Option_Groups
{
    /**
     * Get types as a source model result
     *
     * @return array
     */
    public function toOptionArray()
    {
        $groups     = array();
        $collection = Mage::helper('customer')->getGroups();

        foreach ($collection as $group) {
            $groups[] = array('value' => $group->getCustomerGroupId(), 'label' => $group->getCustomerGroupCode());
        }

        return $groups;
    }
}
