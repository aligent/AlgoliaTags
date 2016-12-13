<?php

class Aligent_AlgoliaTags_Helper_Entity_Categoryhelper extends Algolia_Algoliasearch_Helper_Entity_Categoryhelper
{
    protected $tagAttribute = null;
    protected $mapTagAttribute = false;

    protected function getTagAttributeMapping() {
        if ($this->tagAttribute === null) {
            $this->tagAttribute = Mage::getStoreConfig('algoliasearch/categories/tag_attribute_mapping');

            if ($this->tagAttribute != '-1') {
                $this->mapTagAttribute = true;
            }
        }
        return $this->tagAttribute;
    }

    public function getObject(Mage_Catalog_Model_Category $category)
    {
        $data = parent::getObject($category);

        $tagAttribute = $this->getTagAttributeMapping();

        if ($this->mapTagAttribute) {
            $tags = explode(',', $category->getData($tagAttribute));
            $data['_tags'] = array_merge($data['_tags'], $tags);
        }
        return $data;
    }
}