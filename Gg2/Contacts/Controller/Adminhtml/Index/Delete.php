<?php

namespace Gg2\Contacts\Controller\Adminhtml\Index;

use Gg2\Contacts\Api\ContactRepositoryInterface;
use Gg2\Contacts\Model\ContactFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';
    protected $resultPageFactory;
    protected $contactFactory;
    protected $contactRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ContactFactory $contactFactory,
        ContactRepositoryInterface $contactRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->contactFactory = $contactFactory;
        $this->contactRepository = $contactRepository;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        try {
            $contact = $this->contactRepository->get($id);
            $this->contactRepository->delete($contact);
            $this->messageManager->addSuccessMessage(__('Your contact has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete contact'));
        }

        return $this->_redirect('*/*/index', ['_current' => true]);
    }
}
