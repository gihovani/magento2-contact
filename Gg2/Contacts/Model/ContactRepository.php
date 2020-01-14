<?php

namespace Gg2\Contacts\Model;

use Gg2\Contacts\Api\ContactRepositoryInterface;
use Gg2\Contacts\Api\Data\ContactInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @var ResourceModel\Contact
     */
    protected $contact;

    /**
     * @var ContactFactory
     */
    protected $contactFactory;

    /**
     * @var array
     */
    private $contacts = [];

    /**
     * @param ResourceModel\Contact $contactResource
     * @param ContactFactory $contactFactory
     */
    public function __construct(
        ResourceModel\Contact $contactResource,
        ContactFactory $contactFactory
    ) {
        $this->contact = $contactResource;
        $this->contactFactory = $contactFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ContactInterface $contact)
    {
        try {
            if ($contact->getEntityId()) {
                $contact = $this->get($contact->getEntityId())->addData($contact->getData());
            }
            $this->contact->save($contact);
            unset($this->contacts[$contact->getId()]);
        } catch (NoSuchEntityException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The "%1" contact was unable to be saved. Please try again.', $contact->getEntityId())
            );
        }
        return $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function get($contactId)
    {
        if (!isset($this->contacts[$contactId])) {
            /** @var Contact $contact */
            $contact = $this->contactFactory->create();
            $this->contact->load($contact, $contactId);
            if (!$contact->getEntityId()) {
                throw new NoSuchEntityException(
                    __('The contact with the "%1" ID wasn\'t found. Verify the ID and try again.', $contactId)
                );
            }
            $this->contacts[$contactId] = $contact;
        }
        return $this->contacts[$contactId];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ContactInterface $contact)
    {
        try {
            $this->contact->delete($contact);
            unset($this->contacts[$contact->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('The "%1" contact couldn\'t be removed.', $contact->getEntityId()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($contactId)
    {
        $model = $this->get($contactId);
        $this->delete($model);
        return true;
    }
}
