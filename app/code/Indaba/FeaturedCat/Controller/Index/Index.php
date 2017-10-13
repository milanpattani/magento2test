<?php
namespace Indaba\FeaturedCat\Controller\Index;
class Index extends \Indaba\FeaturedCat\App\Action\Action
{
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}