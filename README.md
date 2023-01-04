# Manually Reindex on the Admin panel


Give the admin user the possibility to run the indexing on the admin panel.
This extension is totally free, easy to install and use.

The code is written in the simplest way, easy to understand, and extend.

## Installation
#### Install via composer
```
composer require themagelover/admin-manually-reindex
```


#### Deploy the extension
```
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento module:enable TheMageLover_AdminManuallyReindex
```

## User guide
_System > Tools > Index Management_

- Choose the Indexers that need to be reindexed.
- In the dropdown **Actions**, choose **Reindex**
- Click on the **Submit** button

