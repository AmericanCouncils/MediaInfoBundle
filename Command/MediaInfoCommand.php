<?php

namespace AC\MediaInfoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Lets you query the `ac.mediainfo` service from the command line.
 *
 * @package ACMediaInfoBundle
 * @author Evan Villemez
 */
class MediaInfoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mediainfo:scan')
            ->setDescription('Wraps the mediainfo command to return stats on a file in various formats.')
            ->setDefinition(array(
                new InputArgument('path', InputArgument::REQUIRED, 'Path to file to analyze with mediainfo.'),
                new InputOption('format', null, InputOption::VALUE_REQUIRED, 'Optionally specify alternate output format (json/yaml/xml/array).', 'yaml')
            ));
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format = $input->getOption('format');
        if (!in_array($format, array('json','yaml','array'))) {
            throw new \InvalidArgumentException("Invalid format chosen.");
        }
                
        $mediainfo = $this->getContainer()->get('ac.mediainfo');
        
        $data = $mediainfo->scan($input->getArgument('path'), $format);
        
        if ('array' === $format) {
            $data = print_r($data, true);
        }
        
        if ('json' === $format) {
            $data = json_encode($data);
        }
        
        if ('yaml' === $format) {
            $dumper = new Dumper();
            $data = $dumper->dump($data, 5);
        }
        
        $output->write($data);
    }
}
