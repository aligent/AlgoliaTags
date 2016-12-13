<?php

class Aligent_AlgoliaTags_Model_Observer
{

    /**
     * Add the _tags attribute as a searchable attribute.
     * This should only occur for category, however the event is triggered for both Category and Product
     * Therefore I have added a check to confirm we are not looking at a product config save.
     *
     * @param Varien_Event_Observer $observer
     */
    public function categoryConfigSaved(Varien_Event_Observer $observer)
    {
        $indexSettings = $observer->getIndexSettings();
        $maxValuesPerFacet = $indexSettings->getData('maxValuesPerFacet');

        //Only update for category. Check to see if product only data is present.
        if ($maxValuesPerFacet === null) {
            $attributesToIndex = $indexSettings->getData('attributesToIndex');

            if( Mage::helper('algoliasearch/entity_categoryhelper')->shouldMapTagAttribute()) {
                $attributesToIndex[] = '_tags';
                $indexSettings->setData('attributesToIndex', $attributesToIndex);
            }
        }
    }
}
