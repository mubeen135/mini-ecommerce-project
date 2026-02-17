<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Classic T-Shirt',
                'description' => 'A comfortable cotton t-shirt for everyday wear.',
                'price' => 19.99,
                'image' => 'https://cdn.pixabay.com/photo/2023/05/08/22/00/tshirt-7979854_1280.jpg'
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Stylish blue denim jeans with a slim fit.',
                'price' => 49.99,
                'image' => 'https://cdn.pixabay.com/photo/2023/02/10/10/02/woman-7780516_1280.jpg'  
            ],
            [
                'name' => 'Leather Wallet',
                'description' => 'Genuine leather wallet with multiple card slots.',
                'price' => 29.99,
                'image' => 'https://cdn.pixabay.com/photo/2022/02/11/09/21/leather-wallet-7006897_1280.jpg'
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Lightweight running shoes for your daily jog.',
                'price' => 79.99,
                'image' => 'https://cdn.pixabay.com/photo/2021/06/03/08/05/sneep-crew-6306330_1280.jpg'
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Track your fitness and notifications with this smart watch.',
                'price' => 199.99,
                'image' => 'https://cdn.pixabay.com/photo/2025/10/21/17/10/smartwatch-9907990_1280.jpg'
            ],
            [
                'name' => 'Backpack',
                'description' => 'Durable backpack for school or travel.',
                'price' => 39.99,
                'image' => 'https://cdn.pixabay.com/photo/2025/12/16/10/28/modern-santa-10018017_1280.png'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}