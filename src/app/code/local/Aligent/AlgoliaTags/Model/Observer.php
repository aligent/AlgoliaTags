<?php

class Aligent_AlgoliaTags_Model_Observer
{
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
