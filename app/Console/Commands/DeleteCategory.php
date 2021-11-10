<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CategoryRepository;

class DeleteCategory extends Command
{
    private $categories;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing category with cli';

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
        $categoryId = $this->ask('Enter category ID');

        if( $category = $this->categories->find($categoryId) ) {

            $category->delete();

            $this->output->success(
                sprintf('Category %d deleted successfully', $category->id)
            );

        } else {

            $this->output->error(
                sprintf('There is no category with ID = %d', $categoryId)
            );

        }

        return 0;
    }
}