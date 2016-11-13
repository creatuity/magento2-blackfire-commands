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
class WriteYamlCommand extends Command
{
    public function __construct(
        \Magento\Framework\App\State $state, $name=null
    ) {
        try {
            $state->setAreaCode('frontend');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            // intentionally left empty
        }
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('blackfire:writeyaml')
            ->setDescription('Writes a new Blackfire yaml file');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryFactory = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $baseURL = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore(1)
            ->getBaseUrl();
        $categories = $categoryFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active',1)
            ->setOrder('position', 'ASC');
        $output->writeln('scenarios:');
        foreach ($categories as $category) :
            $categoryURL = $category->getURL();
            $categoryURL = str_replace($baseURL, '/', $categoryURL);
            $output->writeln("     " . trim($category->getName()) . " Category Page:");
            $output->writeln("          - " . $categoryURL . "");
        endforeach;
        $output->writeln('');
        $output->writeln("tests:");
        $output->writeln('   "SQL Query Count":');
        $output->writeln("     assertions: ");
        $output->writeln("          -");
        $output->writeln("                  expression: 'metrics.sql.queries.count <= 10'");
        $output->writeln("     path: '/.*'");
        $output->writeln("     methods:");
        $output->writeln("          - ANY");
        $output->writeln('   "Optimized Composer Autoloader":');
        $output->writeln("     assertions: ");
        $output->writeln("          -");
        $output->writeln("                  expression: 'metrics.composer.autoload.find_file.count <= 50'");
        $output->writeln("     path: '/.*'");
        $output->writeln("     command: '.*'");
        $output->writeln("     methods:");
        $output->writeln("          - ANY");
        $output->writeln('   "Enable Full Page Cache":');
        $output->writeln("     assertions: ");
        $output->writeln("          -");
        $output->writeln("                  expression: 'metrics.magento2.ee.installed.count == 0 or metrics.magento2.all.cache.full_page.builtin.hit.count == 1'");
        $output->writeln("     path: '/.*'");
        $output->writeln("     command: '.*'");
        $output->writeln("     methods:");
        $output->writeln("          - ANY");
        $output->writeln('   "Enable Block Cache":');
        $output->writeln("     assertions: ");
        $output->writeln("          -");
        $output->writeln("                  expression: 'metrics.magento2.ee.installed.count == 0 or metrics.magento2.all.cache.full_page.builtin.hit.count == 1 or metrics.magento2.all.frontend.blocks.with_lifetime.count > 0 and metrics.magento2.all.frontend.blocks.load_cache.hit.count > 0'");
        $output->writeln("     path: '/.*'");
        $output->writeln("     command: '.*'");
        $output->writeln("     methods:");
        $output->writeln("          - ANY");
        $output->writeln('     "Pages should not become slower":');
        $output->writeln('          path: "/.*"');
        $output->writeln('          assertions:');
        $output->writeln('               - "percent(main.wall_time) < 10%"');
        $output->writeln('               - "diff(metrics.sql.queries.count) < 2"');
    }
}
