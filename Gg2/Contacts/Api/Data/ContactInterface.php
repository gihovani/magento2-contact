<?php

namespace Gg2\Contacts\Api\Data;

interface ContactInterface
{
    const TABLE_NAME = 'gg2_contacts_contact';
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const COMMENT = 'comment';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_ACTIVE = 'is_active';

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId);

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment(string $comment);

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @param int $isActive
     * @return $this
     */
    public function setIsActive(int $isActive);

    /**
     * @return int|null
     */
    public function getEntityId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getComment();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return int
     */
    public function getIsActive();

}
