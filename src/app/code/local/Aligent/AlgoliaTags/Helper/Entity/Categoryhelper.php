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

    /**
     * Update the _tags attribute to include the new mapped attribute value before sending to Algolia.
     *
     * @param Mage_Catalog_Model_Category $category
     * @return array
     */
    public function getObject(Mage_Catalog_Model_Category $category)
    {
        $data = parent::getObject($category);

        if ($this->shouldMapTagAttribute()) {
            //explode list, trim, remove empty, merge with original _tags attribute
            $data['_tags'] = array_merge($data['_tags'], array_filter(array_map('trim', explode(',', $category->getData($this->getTagAttributeMapping())))));
        }
        return $data;
    }

    /**
     * Include the category attribute in the collection query.
     *
     * @param $storeId
     * @param null $categoryIds
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection|Object
     */
    public function getCategoryCollectionQuery($storeId, $categoryIds = null)
    {
        $categories = parent::getCategoryCollectionQuery($storeId, $categoryIds);

        if ($this->shouldMapTagAttribute()) {
            $categories->addAttributeToSelect($this->getTagAttributeMapping());
        }

        return $categories;
    }
}