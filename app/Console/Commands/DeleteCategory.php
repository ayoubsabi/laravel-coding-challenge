<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CategoryService;

class DeleteCategory extends Command
{
    private $categoryService;

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
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();

        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->ask('Enter category ID');

        if ($category = $this->categoryService->getCategoryById($id)) {
            $this->categoryService->deleteCategory($category);

            $this->output->success(
                sprintf('Category %d deleted successfully', $category->id)
            );
        } else {
            $this->output->error(
                sprintf('There is no category with ID = %d', $id)
            );
        }

        return 0;
    }
}