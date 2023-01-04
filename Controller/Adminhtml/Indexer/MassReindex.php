<?php

namespace TheMageLover\AdminManuallyReindex\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;

/**
 * Class MassReindex
 * Controller to run the Reindex Manually
 */
class MassReindex extends Action implements HttpPostActionInterface
{
    /** @var IndexerRegistry */
    protected IndexerRegistry $indexerRegistry;

    /**
     * @param Context $context
     * @param IndexerRegistry $indexerRegistry
     */
    public function __construct(Context $context, IndexerRegistry $indexerRegistry)
    {
        parent::__construct($context);
        $this->indexerRegistry = $indexerRegistry;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $indexerIds = $this->getRequest()->getParam('indexer_ids');
        if (!isset($indexerIds) || !is_array($indexerIds)) {
            $this->messageManager->addErrorMessage(__('Please select indexers.'));
        } else {
            try {
                foreach ($indexerIds as $indexerId) {
                    $indexer = $this->indexerRegistry->get($indexerId);
                    $indexer->reindexAll();
                }

                // Success message
                $count = count($indexerIds);
                $subject = $count > 1 ? $count . ' indexers' : 'An indexer';
                $this->messageManager->addSuccessMessage(__('%1 have been run successfully.', $subject));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __("We couldn't reindex because of an error.")
                );
            }
        }
        $this->_redirect('indexer/indexer/list');
    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Indexer::index');
    }
}
