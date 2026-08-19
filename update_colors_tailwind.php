<?php
$dir = new RecursiveDirectoryIterator('C:\VocaMarket-666\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    "'#2563EB'" => "'#3B82F6'", // primary hex in js
    "#2563EB" => "#3B82F6", // primary hex in html/svg
    "'primary-dark': '#1D4ED8'" => "'primary-dark': '#2563EB'", // hover color
    "rgba(37, 99, 235" => "rgba(59, 130, 246" // chart rgba
];

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $newContent = strtr($content, $replacements);
    if($newContent !== $content) {
        file_put_contents($path, $newContent);
        echo "Updated: " . $path . PHP_EOL;
    }
}
echo "Done.";
