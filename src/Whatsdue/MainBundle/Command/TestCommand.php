<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/19/15
 * Time: 12:37
 * Description: This deals with updating users to pipedrive
 */

namespace Whatsdue\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('Play with something new')
            ->addOption(
                'params',
                null,
                InputOption::VALUE_NONE,
                'If set, we will test parameters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('params')) {
             $this->testParameters();
        }

        var_dump(getdate());
        $output->writeln("Finished");
        return "this is unnecessary";
    }

    protected function testParameters(){
        echo $this->getContainer()->getParameter('pipedrive.apiKey');
        echo "\n";
        return null;
    }
}