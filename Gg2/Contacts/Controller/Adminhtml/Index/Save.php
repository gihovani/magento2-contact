<?php

namespace Gg2\Contacts\Controller\Adminhtml\Index;

use Gg2\Contacts\Api\ContactRepositoryInterface;
use Gg2\Contacts\Controller\RegistryConstants;
use Gg2\Contacts\Model\Contact;
use Gg2\Contacts\Model\ContactFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';
    protected $resultPageFactory;
    protected $contactFactory;
    protected $contactRepository;
    protected $dataPersistor;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ContactFactory $contactFactory,
        ContactRepositoryInterface $contactRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->contactFactory = $contactFactory;
        $this->contactRepository = $contactRepository;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $path = '*/*/';
        $id = $this->getRequest()->getPostValue('entity_id', 0);
        /** @var Contact $model */
        $model = $this->contactFactory->create();
        if ($this->getRequest()->isPost()) {
            $path = '';
            $data = $this->getRequest()->getPostValue();
            $validateResult = $model->validateData(new DataObject($data));
            if ($validateResult !== true) {
                foreach ($validateResult as $errorMessage) {
                    $this->messageManager->addErrorMessage($errorMessage);
                }
                $this->dataPersistor->set(RegistryConstants::FORM_DATA_CONTACT, $data);
                return $this->_redirect($path, ['id' => $id]);
            }
            try {
                if ($id) {
                    $model = $this->contactRepository->get($id);
                }
                $model->loadPost($data);
                $this->contactRepository->save($model);
                $this->dataPersistor->clear(RegistryConstants::FORM_DATA_CONTACT);
                $this->messageManager->addSuccessMessage(__('Successfully saved the item.'));
                if (!$this->getRequest()->getParam('back')) {
                    $path = '*/*/';
                }
            } catch (LocalizedException $e) {
                $path = '*/*/';
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the contact.'));
            }
            $this->dataPersistor->set(RegistryConstants::FORM_DATA_CONTACT, $data);
        }

        return $this->_redirect($path, ['id' => $id]);
    }

    protected function _redirect($path, $arguments = [])
    {
        if ($path !== '*/*/') {
            $path = (isset($arguments['id']) && $arguments['id']) ? '*/*/edit' : '*/*/newAction';
        }
        return parent::_redirect($path, $arguments);
    }

}
