<?php

/**
 * Algolia category attributes field.
 */
class Aligent_AlgoliaTags_Model_System_Config_Form_Field_CategoryAttributes
{

    /**
     * toOptionArray function.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $returnArray = array();
        $returnArray[] = array('value' => '-1', 'label' => 'None');

        /** @var Algolia_Algoliasearch_Helper_Entity_Categoryhelper $category_helper */
        $category_helper = Mage::helper('algoliasearch/entity_categoryhelper');

        $searchableAttributes = $category_helper->getAllAttributes();
        foreach ($searchableAttributes as $key => $label) {
            $returnArray[] = array('value' => $key, 'label' => $key);
        }

        return $returnArray;
    }
}
