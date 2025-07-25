<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command {
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new repository, service, and interface';

    public function handle() {
        $name = $this->argument('name');

        // Define paths
        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        $interfacePath = app_path("Repositories/{$name}RepositoryInterface.php");
        $servicePath = app_path("Services/{$name}Service.php");

        // Check if files already exist
        if (File::exists($repositoryPath) || File::exists($interfacePath) || File::exists($servicePath)) {
            $this->error("Repository, Interface, or Service already exists!");
            return;
        }

        // Ensure directories exist
        File::ensureDirectoryExists(app_path('Repositories'));
        File::ensureDirectoryExists(app_path('Services'));

        // Create Interface
        $interfaceTemplate = <<<PHP
        <?php

        namespace App\Repositories;

        interface {$name}RepositoryInterface {
            public function getAll();
            public function getById(int \$id);
            public function create(array \$data);
            public function update(int \$id, array \$data);
            public function delete(int \$id);
        }
        PHP;

        // Create Repository
        $repositoryTemplate = <<<PHP
        <?php

        namespace App\Repositories;

        use App\Models\\{$name};

        class {$name}Repository implements {$name}RepositoryInterface {
            public function getAll() {
                return {$name}::all();
            }

            public function getById(int \$id) {
                return {$name}::findOrFail(\$id);
            }

            public function create(array \$data) {
                return {$name}::create(\$data);
            }

            public function update(int \$id, array \$data) {
                \$record = {$name}::findOrFail(\$id);
                \$record->update(\$data);
                return \$record;
            }

            public function delete(int \$id) {
                \$record = {$name}::findOrFail(\$id);
                return \$record->delete();
            }
        }
        PHP;

        // Create Service
        $serviceTemplate = <<<PHP
        <?php

        namespace App\Services;

        use App\Repositories\\{$name}RepositoryInterface;

        class {$name}Service {
            protected \${$name}Repository;

            public function __construct({$name}RepositoryInterface \${$name}Repository) {
                \$this->{$name}Repository = \${$name}Repository;
            }

            public function getAll() {
                return \$this->{$name}Repository->getAll();
            }

            public function getById(int \$id) {
                return \$this->{$name}Repository->getById(\$id);
            }

            public function create(array \$data) {
                return \$this->{$name}Repository->create(\$data);
            }

            public function update(int \$id, array \$data) {
                return \$this->{$name}Repository->update(\$id, \$data);
            }

            public function delete(int \$id) {
                return \$this->{$name}Repository->delete(\$id);
            }
        }
        PHP;

        // Write files
        File::put($interfacePath, $interfaceTemplate);
        File::put($repositoryPath, $repositoryTemplate);
        File::put($servicePath, $serviceTemplate);

        $this->info("Repository, Interface, and Service created successfully!");
    }
}