<?php

namespace App\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use App\Services\Product\ProductService;

class CreateProduct extends Command
{
    private $productService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product with cli';

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
        try {

            $product = $this->productService->createProduct([
                    'name' => $this->ask('Enter product name'),
                    'description' => $this->ask('Enter product description'),
                    'price' => $this->ask('Enter product price'),
                    'image' => file_get_contents($this->ask('Enter product image url')),
                    'category_id' => $this->ask('Enter category ID'),
                ]
            );
    
            $this->output->success(
                sprintf('Product %s created successfully', $product->name)
            );

        } catch (Throwable $th) {
            
            $this->output->error($th->getMessage());
            
        }
    }
}
