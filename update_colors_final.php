<?php
$dir = new RecursiveDirectoryIterator('C:\VocaMarket-666\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    "'#3A86FF'" => "'#2563EB'",
    "#3A86FF" => "#2563EB",
    "'primary-dark': '#2A75E6'" => "'primary-dark': '#1D4ED8'", // updating hover
    "rgba(58, 134, 255" => "rgba(37, 99, 235" // updating chart js rgba
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
