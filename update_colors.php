<?php
$dir = new RecursiveDirectoryIterator('C:\VocaMarket-666\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    "primary: '#0a84d4'" => "primary: '#004AAD'",
    "accent: '#ffb900'" => "accent: '#F1FF00'",
    "'primary-dark': '#0a84d4'" => "'primary-dark': '#00337A'",
    "'accent-hover': '#ffb900'" => "'accent-hover': '#D6E200'",
    "600: '#0a84d4'" => "600: '#004AAD'",
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
