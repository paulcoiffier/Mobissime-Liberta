<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use MyCrm\Modules\LibertaModules\Lib\ModUtils;
use App\Lib\ModuleUtils;

class ModuleCommand extends Command
{
    private $entityManager;
    private $logger;


    protected function configure()
    {

        /** Logger init */
        $this->logger = new \Liberta\MLogger\Logger(log_dir);
        $this->logger->setLogLevelThreshold(log_threshold);
        $this->logger->logWithClass(LEVEL_INFO, "Init logger", get_class());
        $this->logger->setDateFormat("d/m/Y H:i:s.u");

        $this->setName("module")
            ->setDescription("Liberta modules interactions")
            ->setDefinition(array(
                new InputOption('update', 'u', InputOption::VALUE_OPTIONAL, 'Update module <module_name>'),
                new InputOption('install', 'i', InputOption::VALUE_OPTIONAL, 'Install module  <module_name>'),
                new InputOption('create', 'c', InputOption::VALUE_OPTIONAL, 'Create new module  <module_name>')
            ))
            ->setHelp(<<<EOT

* Liberta modules actions *

<info>--update</info>
<info>Specifiy the module_name and run the update process to update your module in Liberta</info>

<info>--install</info>
<info>Specifiy the module_name and run the installation process to install and manage your module in Liberta</info>

<info>--create</info>
<info>Specifiy the module_name and run the module creation process to create a new Liberta module</info>

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->logger->logWithClass(LEVEL_DEBUG, "function execute", get_class());

        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);

        if ($input->getOption('update')) {

            $this->logger->logWithClass(LEVEL_DEBUG, "getOption 'update'", get_class());

            /**
             * Module update
             */
            if ($input->getOption('update') == "all") {
                /**
                 * Loop for update all modules
                 */
                $modUtils = new ModUtils($this->entityManager);
                $moduleRepository = $this->entityManager->getRepository('App\Entities\Module');
                $modules = $moduleRepository->findAll();

                foreach ($modules as $module) {
                    $output->writeln('Update module "' . $input->getOption('update') . '"');
                    $output->writeln('Author : ' . $module->getModAuthor());
                    $output->writeln('Description : ' . $module->getModDescription());
                    $modUtils->register_module($module, install_sys_dir);
                    $output->writeln("Module updated");
                    $output->writeln(".");
                }
                
            } else {
                /**
                 * Update one module by it's name
                 */
                $moduleUtils = new ModuleUtils($this->entityManager);
                $module = $moduleUtils->getModuleByName($input->getOption('update'));

                $output->writeln('Update module "' . $input->getOption('update') . '"');
                $output->writeln('Author : ' . $module->getModAuthor());
                $output->writeln('Description : ' . $module->getModDescription());

                if ($module != null) {
                    $modUtils = new ModUtils($this->entityManager);
                    $modUtils->register_module($module, install_sys_dir);
                    $output->writeln("Module updated");
                } else {
                    throw new \RuntimeException("Module '" . $input->getOption('update') . "' does not exist");
                }

            }
        } else if ($input->getOption('install')) {
            /**
             * Module installation
             */
            $output->writeln("install");
            if ($input->getOption('install') == "all") {
                $output->writeln("Install all modules");
            } else if (($input->getOption('install') != "all") && (trim(strlen($input->getOption('install')) >= 1))) {
                $output->writeln("Install module : " . $input->getOption('install'));
            } else {
                throw new \InvalidArgumentException('Module name is missing');
            }
        } else if ($input->getOption('create')) {
            /**
             * Module creation
             */
            $output->writeln("Create module : " . $input->getOption('create'));
        } else {
            throw new \InvalidArgumentException('Bad syntax');
        }

        //$helper = $this->getHelper('question');
        //$question = new Question('Please enter the name of the bundle : ', '');
        //$bundle = $helper->ask($input, $output, $question);
        //$output->writeln('Result : ' . $input->getFirstArgument());

    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

}