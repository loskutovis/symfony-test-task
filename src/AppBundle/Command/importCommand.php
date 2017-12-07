<?php

namespace AppBundle\Command;

use AppBundle\Entity\TblProductData;
use AppBundle\Service\AbstractParser;
use AppBundle\Service\CsvParser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class importCommand
 * @package AppBundle\Command
 */
class importCommand extends ContainerAwareCommand
{
    /**
     * Changes settings of the command
     */
    protected function configure()
    {
       $this->addArgument('file', InputArgument::REQUIRED, 'A csv file')
            ->addArgument('test', InputArgument::OPTIONAL, 'Test mode (1 or 0)')
            ->setName('app:import-test')
            ->setDescription('Insert data from csv file to database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @var string $file Path to the csv file
     * @var integer $isTest Type of the environment
     * @var integer $itemsTotal Number of items
     * @var AbstractParser $csv Content of the file
     * @var TblProductData|null $productData Product data from the file
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $isTest = (bool) $input->getArgument('test');

        $isTest = isset($isTest) ? $isTest : 0;

        if (!file_exists($file)) {
            $output->writeln('The file does not exist');
        } else {
            $parser = new CsvParser($file);
            $parsedData = $parser->parse();

            $itemsTotal = count($parsedData);
            $notImported = [];

            $em = $this->getContainer()->get('doctrine')->getManager();

            foreach ($parsedData as $data) {
                $productData = TblProductData::loadFields($data);

                if (!empty($productData) && $productData->checkProductData()) {
                    $em->persist($productData);
                } else {
                    $notImported[] = $data['Product Name'];
                }
            }

            if (!$isTest) {
                $em->flush();
            }

            $itemsSkipped = count($notImported);
            $itemsProcessed = $itemsTotal - $itemsSkipped;

            $output->writeln('Import is done.');
            $output->writeln('Items total: ' . $itemsTotal);
            $output->writeln('Items processed: ' . $itemsProcessed);
            $output->writeln('Items skipped: ' . $itemsSkipped);

            if ($itemsSkipped > 0) {
                $output->writeln('Some products could not be imported:');

                foreach ($notImported as $item) {
                    $output->writeln($item);
                }
            }
        }
    }
}