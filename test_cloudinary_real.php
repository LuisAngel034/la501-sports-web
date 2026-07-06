<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

try {
    $realImagePath = 'C:/Users/HP_User/.gemini/antigravity-ide/brain/b6bd1e30-e8ee-437b-96f7-326e41f66697/carrusel_burgers_beer_1783240148615.png';
    if (!file_exists($realImagePath)) {
        throw new \Exception("Real image file does not exist at: " . $realImagePath);
    }
    
    $uploadedFile = new UploadedFile(
        $realImagePath,
        'carrusel_burgers_beer.png',
        'image/png',
        null,
        true // test mode
    );

    echo "Attempting real image upload to Cloudinary...\n";
    $url = CloudinaryService::upload($uploadedFile);
    echo "SUCCESS! Cloudinary URL: " . $url . "\n";
    
    // Check if the URL is accessible
    echo "Checking URL HTTP status...\n";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Status Code: " . $statusCode . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
