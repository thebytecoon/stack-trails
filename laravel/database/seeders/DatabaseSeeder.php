<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductStorage;
use App\Models\ShippingOption;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $colors = [
        "lightpink" => "#FFB6C1",
        "lightblue" => "#ADD8E6",
        "lightgreen" => "#90EE90",
        "lightyellow" => "#FFFFE0",
        "lightgray" => "#D3D3D3",
    ];

    protected $storages = [
        '256GB',
        '512GB',
        '1TB',
    ];

    protected $categories = [
        "electronics",
        "clothing",
        "books",
        "home_appliances",
        "toys",
        "sports",
        "health",
        "beauty",
        "automotive",
        "garden",
    ];

    protected $brands = [
        "Sony",
        "Samsung",
        "Apple",
        "LG",
        "Panasonic",
        "Dell",
        "HP",
        "Lenovo",
        "Asus",
        "Philips",
    ];

    protected $product_info = [
        "quest" => [
            "images" => [
                "https://images.unsplash.com/photo-1617802690992-15d93263d3a9",
                "https://images.unsplash.com/photo-1605647540924-852290f6b0d5"
            ],
            "features" => [
                "See your surroundings in full color for mixed reality.",
                "Pancake lenses for clearer, slimmer display.",
                "Snapdragon XR2 Gen 2 for better performance.",
                "Haptics and better tracking.",
                "Backward compatible with Quest 2 games.",
            ],
        ],
        "headset" => [
            "images" => [
                "https://images.unsplash.com/photo-1505740420928-5e560c06d30e",
                "https://images.unsplash.com/photo-1583394838336-acd977736f90",
                "https://images.unsplash.com/photo-1484704849700-f032a568e944",
                "https://images.unsplash.com/photo-1628202926206-c63a34b1618f",
                "https://images.unsplash.com/photo-1588423771073-b8903fbb85b5",
            ],
            "features" => [
                "High-resolution display for immersive visuals.",
                "Adjustable head strap for comfort during long sessions.",
                "Built-in audio for an immersive sound experience.",
                "Wireless connectivity for freedom of movement.",
                "Compatible with a wide range of VR games and applications.",
            ]
        ],
        "pos_machine" => [
            "images" => [
                "https://images.unsplash.com/photo-1728044849347-ea6ff59d98dd"
            ],
            "features" => [
                "Compact design for easy placement on counters.",
                "Touchscreen interface for intuitive operation.",
                "Integrated card reader for secure transactions.",
                "Supports multiple payment methods including cash and card.",
                "Customizable settings for different business needs.",
            ]
        ],
        "osciloscope" => [
            "images" => [
                "https://images.unsplash.com/photo-1580983230786-ce385a434707"
            ],
            "features" => [
                "High bandwidth for accurate signal analysis.",
                "Multiple channels for simultaneous signal monitoring.",
                "Large display for easy viewing of waveforms.",
                "USB connectivity for data transfer and analysis.",
                "Compact design for portability and ease of use.",
            ]
        ],
        "laptop" => [
            "images" => [
                "https://images.unsplash.com/photo-1496181133206-80ce9b88a853"
            ],
            "features" => [
                "High-performance processor for fast computing.",
                "Lightweight and portable design for on-the-go use.",
                "Long battery life for extended use without charging.",
                "High-resolution display for clear visuals.",
                "Multiple connectivity options including USB-C and HDMI.",
            ]
        ],
        "mouse" => [
            "images" => [
                "https://images.unsplash.com/photo-1527864550417-7fd91fc51a46"
            ],
            "features" => [
                "Ergonomic design for comfortable use.",
                "Wireless connectivity for freedom of movement.",
                "Adjustable DPI settings for precision control.",
                "Long battery life for extended use.",
                "Customizable buttons for personalized functionality.",
            ]
        ],
        "drone" => [
            "images" => [
                "https://images.unsplash.com/photo-1487887235947-a955ef187fcc"
            ],
            "features" => [
                "High-resolution camera for stunning aerial photography.",
                "GPS navigation for precise flight control.",
                "Long flight time for extended exploration.",
                "Obstacle avoidance for safe flying.",
                "Compact and foldable design for easy transport.",
            ]
        ],
        "glasses" => [
            "images" => [
                "https://plus.unsplash.com/premium_photo-1733749585363-062125288d04"
            ],
            "features" => [
                "Lightweight and comfortable for all-day wear.",
                "UV protection for eye safety.",
                "Scratch-resistant lenses for durability.",
                "Stylish design for a modern look.",
                "Available in various colors and styles.",
            ]
        ],
        "screen" => [
            "images" => [
                "https://images.unsplash.com/photo-1496171367470-9ed9a91ea931"
            ],
            "features" => [
                "High-definition display for crystal-clear visuals.",
                "Multiple connectivity options including HDMI and USB-C.",
                "Adjustable stand for optimal viewing angles.",
                "Built-in speakers for an immersive audio experience.",
                "Slim design for modern aesthetics.",
            ]
        ],
    ];

    protected $shipping_options = [
        [
            "name" => "Standard Shipping",
            "description" => "5-7 business days",
            "price" => 0.0,
        ],
        [
            "name" => "Express Shipping",
            "description" => "2-3 business days",
            "price" => 15.99,
        ],
        [
            "name" => "Overnight Shipping",
            "description" => "Next business day",
            "price" => 29.99,
        ],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'admin@localhost.com',
                'password' => bcrypt('1234'),
            ]);

            $this->command->info('Creating addresses...');
            $user->addresses()->create([
                'name' => 'Home',
                'names' => 'John Doe',
                'address_line_1' => '123 Main Street',
                'address_line_2' => 'Apt 4B',
                'country' => 'United States',
                'city' => 'New York, NY',
                'postal_code' => '10001',
                'phone_number' => '(555) 123-4567',
                'default' => true,
            ]);

            $user->addresses()->create([
                'name' => 'Work',
                'names' => 'John Doe',
                'address_line_1' => '456 Business Ave',
                'address_line_2' => 'Suite 200',
                'country' => 'United States',
                'city' => 'New York, NY',
                'postal_code' => '10005',
                'phone_number' => '(555) 987-6543',
                'default' => false,
            ]);

            $this->command->info("Creating payment methods...");
            $user->payment_methods()->create([
                "type" => "Visa",
                "card_number" => "4387",
                "cardholder_name" => "John Doe",
                "expiry_date" => "2026-12-31",
                "code" => "123",
            ]);

            $this->command->info('Creating colors...');
            foreach ($this->colors as $name => $hex) {
                Color::create([
                    'display_name' => ucfirst($name),
                    'hex_code' => $hex,
                ]);
            }

            $this->command->info('Creating categories...');
            foreach ($this->categories as $category) {
                Category::create([
                    'display_name' => ucfirst($category),
                ]);
            }

            $categories = Category::all();

            $this->command->info('Creating brands...');
            foreach ($this->brands as $brand) {
                Brand::create([
                    'display_name' => ucfirst($brand),
                ]);
            }

            $brands = Brand::all();

            $this->command->info('Creating storage options...');
            foreach ($this->storages as $storage) {
                ProductStorage::create([
                    'display_name' => $storage,
                ]);
            }

            $this->command->info('Creating shipping options...');
            foreach ($this->shipping_options as $option) {
                ShippingOption::create([
                    'name' => $option['name'],
                    'description' => $option['description'],
                    'price' => $option['price'],
                ]);
            }

            $this->command->info('Creating products...');
            for ($i = 0; $i < 300; $i++) {
                $product_info = $this->product_info[array_rand($this->product_info)];

                $image = $product_info['images'][array_rand($product_info['images'])];

                Product::factory()->create([
                    'owner_id' => $user->id,
                    'brand_id' => $brands->random()->id,
                    'category_id' => $categories->random()->id,
                    'image' => $image,
                ]);
            }
        });
    }
}
