<?php
namespace Indaba\FeaturedCat\Helper;

use Magento\Framework\App\Action\Action;

/**
 * Indaba FeaturedCat Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $storeManager;
    protected $categoryRepository;
    protected $productFactory;
    protected $_catalogLayer;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver
    ) {
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        $this->productFactory = $productFactory;
        $this->_catalogLayer = $layerResolver->get();
        parent::__construct($context);
    }

    public function getCategoryThumbUrl($category)
    {
        $url   = false;
        $image = $category->getFeaturedImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        } else {
            $url = $this->storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'catalog/category/placeholder.png';
        }

        return $url;
    }

    public  function getCategoryUrl($categoryId)
    {
        $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());

        return $category->getUrl();
    }

    public function getProductCount($categoryId)
    {
        $category = $this->categoryRepository->get($categoryId);

        $layer = $this->getLayer();
        $layer->setCurrentCategory($category);
        $collection = $layer->getProductCollection();

        return $collection->getSize();
    }

    public function getLayer()
    {
        return $this->_catalogLayer;
    }
}

