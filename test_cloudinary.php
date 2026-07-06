<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

try {
    // Create a temporary dummy text file
    $tempFile = tempnam(sys_get_temp_dir(), 'test');
    file_put_contents($tempFile, 'this is a dummy image file content');
    
    $uploadedFile = new UploadedFile(
        $tempFile,
        'dummy.png',
        'image/png',
        null,
        true // test mode
    );

    echo "Attempting upload to Cloudinary...\n";
    $url = CloudinaryService::upload($uploadedFile);
    echo "SUCCESS! Cloudinary URL: " . $url . "\n";
    
    if (file_exists($tempFile)) {
        unlink($tempFile);
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
