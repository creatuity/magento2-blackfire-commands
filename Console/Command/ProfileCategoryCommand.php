<?php

namespace Creatuity\BlackfireCommands\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProfileCategoryCommand
 */
class ProfileCategoryCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('blackfire:category')
            ->setDescription('Profiles all category pages');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $categoryHelper = $this->helper('Magento\Catalog\Helper\Category');
        foreach ($categoryHelper->getStoreCategories() as $category) :
            $output->writeln('<info>Profiling ' . $categoryHelper->getCategoryUrl($category) . '</info>');
        endforeach;
        $output->writeln('<info>Done</info>');
    }
}
