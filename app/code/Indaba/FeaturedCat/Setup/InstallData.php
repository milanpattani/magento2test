<?php

namespace Indaba\FeaturedCat\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Category::ENTITY,
            'indaba_short_description',
            [
                'type' => 'text',
                'label' => 'Featured Cat Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 4,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'group' => 'General Information',
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'featured_category',
            [
                'type' => 'int',
                'label' => 'Featured Category',
                'input' => 'boolean',
                'required' => false,
                'sort_order' => 5,
                'source'   => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'is_html_allowed_on_front' => true,
                'group' => 'General Information',
                'user_defined' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'featured_image', [
                'type'      	=> 'varchar',
                'label'      	=> 'Featured Image - Thumb',
                'input'     	=> 'image',
                'required' 	    =>  false,
                'sort_order'    =>  6,
                'backend'	    =>  'Indaba\FeaturedCat\Model\Category\Attribute\Backend\Thumb',
                'global'    	=>  \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'    	    =>  'General Information',
            ]
        );

    }
}