<?php
namespace Indaba\FeaturedCat\Model\Category;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
    protected function addUseDefaultSettings($category, $categoryData)
    {
        $data = parent::addUseDefaultSettings($category, $categoryData);

        if (isset($data['featured_image'])) {
            unset($data['featured_image']);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $helper           	= $objectManager->get('\Indaba\FeaturedCat\Helper\Data');

            $data['featured_image'][0]['name'] = $category->getData('featured_image');
            $data['featured_image'][0]['url']  	= $helper->getCategoryThumbUrl($category);
        }

        return $data;
    }

    protected function getFieldsMap()
    {
        $fields = parent::getFieldsMap();
        $fields['custom_content'][] = 'featured_image'; // NEW FIELD

        return $fields;
    }

}