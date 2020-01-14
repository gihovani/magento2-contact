<?php

namespace Gg2\Contacts\Model\ResourceModel\Contact;

use Gg2\Contacts\Api\Data\ContactInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected $_idFieldName = ContactInterface::ENTITY_ID;

    protected function _construct()
    {
        $this->_init('Gg2\Contacts\Model\Contact', 'Gg2\Contacts\Model\ResourceModel\Contact');
    }
}
