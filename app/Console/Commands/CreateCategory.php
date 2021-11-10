<?php

namespace App\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use App\Repositories\CategoryRepository;

class CreateCategory extends Command
{
    private $categories;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new category with cli';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $categories)
    {
        parent::__construct();

        $this->categories = $categories;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        try {

            $category = $this->categories->create([
                'name' => $this->ask('Enter category name'),
                'parent_id' => $this->ask('Enter parent ID', null),
            ]);
    
            $this->output->success(
                sprintf('Category %s created successfully', $category->name)
            );

        } catch (Throwable $th) {
            
            $this->output->error($th->getMessage());
            
        }

        return 0;
    }
}