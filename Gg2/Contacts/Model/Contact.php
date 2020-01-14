<?php

namespace Gg2\Contacts\Model;

use Gg2\Contacts\Api\Data\ContactInterface;
use Magento\Framework\DataObject;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Contact extends AbstractModel implements ContactInterface, IdentityInterface
{
    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function setComment(string $comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function setIsActive(int $isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function loadPost(array $data)
    {
        foreach ($data as $key => $value) {
            if ($value) {
                $this->setData($key, $value);
            }
        }
        return $this;
    }

    public function validateData(DataObject $dataObject)
    {
        $result = [];
        if (trim($dataObject->getData('name')) === '') {
            $result[] = __('Enter the Name and try again.');
        }
        if (trim($dataObject->getData('comment')) === '') {
            $result[] = __('Enter the comment and try again.');
        }

        if (false === \strpos($dataObject->getData('email'), '@')) {
            $result[] = __('The email address is invalid. Verify the email address and try again.');
        }

        return !empty($result) ? $result : true;
    }


    protected function _construct()
    {
        $this->_init('Gg2\Contacts\Model\ResourceModel\Contact');
    }
}
