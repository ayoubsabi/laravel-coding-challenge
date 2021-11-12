<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

class DeleteProduct extends Command
{
    private $productService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing product with cli';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->ask('Enter product ID');

        if ($product = $this->productService->getProductById($id)) {
            $this->productService->deleteProduct($product);

            $this->output->success(
                sprintf('Product %d deleted successfully', $product->id)
            );
        } else {
            $this->output->error(
                sprintf('There is no product with ID = %d', $id)
            );
        }

        return 0;
    }
}
