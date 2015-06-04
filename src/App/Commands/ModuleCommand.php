<?php
/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 04/06/2015
 * Time: 02:28
 */

namespace App\Commands;

use App\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Question\Question;

class ModuleCommand extends Command
{
    protected function configure()
    {

        $this->setName("module")
            ->setDescription("Display the module list")
            /*->setDefinition(array(
                new InputOption('start', 's', InputOption::VALUE_OPTIONAL, 'Start number of the range of Fibonacci number', 1),
                new InputOption('stop', 'e', InputOption::VALUE_OPTIONAL, 'stop number of the range of Fibonacci number', 1)
            ))*/
            ->setHelp(<<<EOT
Display the fibonacci numbers between a range of numbers given as parameters

Usage:

<info>php console.php phpmaster:fibonacci 2 18 <env></info>

You can also specify just a number and by default the start number will be 0
<info>php console.php phpmaster:fibonacci 18 <env></info>

If you don't specify a start and a stop number it will set by default [0,100]
<info>php console.php phpmaster:fibonacci<env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);
        $output->writeln('<header>Module command</header>');

        $helper = $this->getHelper('question');

        $question = new Question('Please enter the name of the bundle : ', '');

        $bundle = $helper->ask($input, $output, $question);
        $output->writeln('Result : '.$input->getFirstArgument());
        /*$question = new ConfirmationQuestion("Are you sure ?", true);

        if (!$helper->ask($input, $output, $question)) {
            return;
        } else {
            $output->writeln("Ok you're sure");
        }*/

        /** Throw error */
        //throw new \InvalidArgumentException('Stop number should be greater than start number');

    }
}