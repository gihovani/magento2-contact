<?php


namespace Gg2\Contacts\Api;


use Gg2\Contacts\Api\Data\ContactInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ContactRepositoryInterface
{
    /**
     * @param ContactInterface $contact
     * @return ContactInterface
     * @throws CouldNotSaveException
     */
    public function save(ContactInterface $contact);

    /**
     * @param int $contactId
     * @return ContactInterface
     * @throws NoSuchEntityException
     */
    public function get($contactId);

    /**
     * @param ContactInterface $contact
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ContactInterface $contact);

    /**
     * @param int $contactId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($contactId);
}
