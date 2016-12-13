<?php

class Aligent_AlgoliaTags_Helper_Entity_Categoryhelper extends Algolia_Algoliasearch_Helper_Entity_Categoryhelper
{
    protected $tagAttribute = null;
    protected $mapTagAttribute = null;

    protected function getTagAttributeMapping()
    {
        if ($this->tagAttribute === null) {
            $this->tagAttribute = Mage::getStoreConfig('algoliasearch/categories/tag_attribute_mapping');

            if ($this->tagAttribute != '-1') {
                $this->mapTagAttribute = true;
            } else {
                $this->mapTagAttribute = false;
            }
        }
        return $this->tagAttribute;
    }

    public function shouldMapTagAttribute()
    {
        if ($this->mapTagAttribute === null) {
            $this->getTagAttributeMapping();
        }
        return $this->mapTagAttribute;
    }

    public function getObject(Mage_Catalog_Model_Category $category)
    {
        $data = parent::getObject($category);

        if ($this->shouldMapTagAttribute()) {
            //explode list, trim, remove empty, merge with original _tags attribute
            $data['_tags'] = array_merge($data['_tags'], array_filter(array_map('trim', explode(',', $category->getData($this->getTagAttributeMapping())))));
        }
        return $data;
    }

    public function getCategoryCollectionQuery($storeId, $categoryIds = null)
    {
        $categories = parent::getCategoryCollectionQuery($storeId, $categoryIds);

        if ($this->shouldMapTagAttribute()) {
            $categories->addAttributeToSelect($this->getTagAttributeMapping());
        }

        return $categories;
    }
}