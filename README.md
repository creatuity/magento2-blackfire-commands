WIP - not yet working. This will become a module for running common Blackfire tests from the Magento 2 bin/magento command line system.

This module is build following the Magento 2 Sample command module - thanks to the Magento 2 core team for providing that example at https://github.com/magento/magento2-samples/tree/master/sample-module-command

Pre-requisites: 
Blackfire.io account
Blackfire command line tool installed

Installing:

composer require creatuity/magento2-blackfire-commands
bin/magento module:enable Creatuity_BlackfireCommands
bin/magento setup:upgrade
bin/magento setup:di:compile
blackfire config


Usage:

TBD
