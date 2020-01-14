<?php

namespace Gg2\Contacts\Model\Contact;

use Gg2\Contacts\Controller\RegistryConstants;
use Gg2\Contacts\Model\Contact;
use Gg2\Contacts\Model\ResourceModel\Contact\CollectionFactory;
use Gg2\Contacts\Model\ResourceModel\Contact\Collection;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var Contact $contact */
        foreach ($items as $contact) {
            $this->loadedData[$contact->getId()] = $contact->getData();
        }

        $data = $this->dataPersistor->get(RegistryConstants::FORM_DATA_CONTACT);
        if (!empty($data)) {
            $contact = $this->collection->getNewEmptyItem();
            $contact->setData($data);
            $this->loadedData[$contact->getId()] = $contact->getData();
            $this->dataPersistor->clear(RegistryConstants::FORM_DATA_CONTACT);
        }
        return $this->loadedData;
    }
}
