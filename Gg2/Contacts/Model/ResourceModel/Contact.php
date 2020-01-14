<?php

namespace Gg2\Contacts\Model\ResourceModel;

use Gg2\Contacts\Api\Data\ContactInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Contact extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ContactInterface::TABLE_NAME, ContactInterface::ENTITY_ID);
    }
}
