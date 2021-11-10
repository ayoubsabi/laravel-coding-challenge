<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ProductRepository;

class DeleteProduct extends Command
{
    private $products;

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
    public function __construct(ProductRepository $products)
    {
        parent::__construct();

        $this->products = $products;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $productId = $this->ask('Enter product ID');

        if( $product = $this->products->find($productId) ) {

            $product->delete();

            $this->output->success(
                sprintf('Product %d deleted successfully', $product->id)
            );

        } else {

            $this->output->error(
                sprintf('There is no product with ID = %d', $productId)
            );

        }

        return 0;
    }
}
