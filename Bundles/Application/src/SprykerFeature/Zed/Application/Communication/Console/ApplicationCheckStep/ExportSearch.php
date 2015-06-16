<?php

namespace SprykerFeature\Zed\Application\Communication\Console\ApplicationCheckStep;

use SprykerFeature\Zed\Application\Business\ApplicationFacade;

/**
 * @method ApplicationFacade getFacade()
 */
class ExportSearch extends AbstractApplicationCheckStep
{
    public function run()
    {
        $this->getFacade()->runCheckStepExportSearch($this->logger);
    }
}
