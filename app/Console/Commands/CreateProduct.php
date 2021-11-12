<?php

namespace App\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use App\Repositories\ProductRepository;
use App\Services\LocalFileUploadService;
use App\Services\ProductService;

class CreateProduct extends Command
{
    const IMAGE_PATH = 'public/images';
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

            $image = file_get_contents($this->ask('Enter product image url'));

            $product = $this->productService->createProduct([
                    'name' => $this->ask('Enter product name'),
                    'description' => $this->ask('Enter product description'),
                    'price' => $this->ask('Enter product price'),
                    'image' => $this->handleFileUpload($image)->getFileName(),
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


    protected function handleFileUpload($file)
    {
        return (new LocalFileUploadService($file))->save(self::IMAGE_PATH);
    }
}
