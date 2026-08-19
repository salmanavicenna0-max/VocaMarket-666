<?php
$dir = new RecursiveDirectoryIterator('C:\VocaMarket-666\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    "'primary-dark': '#00337A'" => "'primary-dark': '#2A75E6'",
    "'accent-hover': '#ffb900'" => "'accent-hover': '#e6a600'",
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
