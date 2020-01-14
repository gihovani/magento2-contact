<?php

namespace Gg2\Contacts\Block\Adminhtml\Contact\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        if ($url = $this->getDeleteUrl()) {
            return [
                'label' => __('Delete Contact'),
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this contact ?') . '\', \'' . $url . '\')',
                'class' => 'delete',
                'sort_order' => 20
            ];
        }
        return [];
    }

    public function getDeleteUrl()
    {
        if ($id = $this->getContactId()) {
            return $this->getUrl('*/*/delete', ['id' => $this->getContactId()]);
        }
        return false;
    }
}
