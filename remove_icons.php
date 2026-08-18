<?php
$files = [
    'C:\VocaMarket-666\resources\views\seller\products.blade.php',
    'C:\VocaMarket-666\resources\views\user\submissions.blade.php',
    'C:\VocaMarket-666\resources\views\Admin\Dashboard.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Handle close button icons first (ph-x) -> replace with "X" text
        $content = preg_replace('/<i class="[^"]*ph-x[^"]*"><\/i>/i', '<span class="font-bold">X</span>', $content);
        
        // Remove all other phosphor icons
        $content = preg_replace('/<i class="ph-[^"]*"><\/i>/i', '', $content);
        
        file_put_contents($file, $content);
        echo "Processed: $file\n";
    }
}
echo "Done.";
