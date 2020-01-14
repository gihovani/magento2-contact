<?php


namespace Gg2\Contacts\Block\Adminhtml\Contact\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    protected $urlBuilder;
    protected $request;

    public function __construct(
        Context $context
    ) {

        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $context->getRequest();
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    public function getContactId()
    {
        return $this->request->getParam('id');
    }

}
