<?php

namespace Timedoor\Filter\Console;

use Illuminate\Console\GeneratorCommand;

class MakeNewFilterCommand extends GeneratorCommand
{
    protected $signature = "make:filter {name}";

    protected $description = "Creating http filter";

    protected $type = "Filter";

    protected function getStub()
    {
        return __DIR__ . '/stubs/filter.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Filter';
    }

    public function handle()
    {
        parent::handle();
    }
}