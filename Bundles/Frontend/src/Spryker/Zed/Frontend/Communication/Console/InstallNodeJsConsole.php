<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Frontend\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * @method \Spryker\Zed\Storage\Business\StorageFacade getFacade()
 */
class InstallNodeJsConsole extends Console
{

    const COMMAND_NAME = 'frontend:install-node-js';
    const DESCRIPTION = 'This command will install node.js.';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info('Check node.js version');

        $process = new Process('node -v');
        $process->run();

        $version = $process->getOutput();
        $this->info(sprintf('Node.js Version "%s"', $version));

        if (preg_match('/^v[0-5]/', $version)) {
            $this->info('Download node source');
            $process = new Process('curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -');
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });

            $this->info('Install node.js');
            $process = new Process('sudo -i apt-get install -y nodejs');
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        }

        return static::CODE_SUCCESS;
    }

}
