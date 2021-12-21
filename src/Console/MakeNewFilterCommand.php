<?php

namespace Timedoor\Filter\Console;

use Illuminate\Console\GeneratorCommand;
use SplFileInfo;

class MakeNewFilterCommand extends GeneratorCommand
{
    protected $signature = "make:filter {--model=}";

    protected $description = "Creating filter on specified model";

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
        if ($this->validate()) $this->createClass();
    }

    protected function createClass()
    {
        $input = $this->getModel() . config('filter.suffix');

        // First we need to ensure that the given name is not a reserved word within the PHP
        // language and that the class name will actually be valid. If it is not valid we
        // can error now and prevent from polluting the filesystem using invalid files.
        if ($this->isReservedName($input)) {
            $this->error('The name "'.$input.'" is reserved by PHP.');

            return false;
        }

        $name = $this->qualifyClass($input);

        $path = $this->getPath($name);

        // Next, We will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') ||
             ! $this->option('force')) &&
             $this->alreadyExists($name)) {
            $this->error($this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info($this->type.' created successfully.');

        if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
            $this->handleTestCreation($path);
        }
    }

    protected function validate()
    {
        if (!$this->getModel()){
            $this->error("options model is required");

            return false;
        } 

        if (!$this->modelIsExists()) {
            $this->error("model not found");

            return false;
        }

        return true;
    }

    private function modelIsExists()
    {
        $model     = $this->getModel();
        $namespace = "App\\Models\\";
        
        return class_exists($namespace . $model);
    }

    private function getModel()
    {
        return ucwords($this->option('model'));
    }
}