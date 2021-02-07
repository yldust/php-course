<?php
require '../vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

const PUBLIC_DIR = __DIR__ . DIRECTORY_SEPARATOR;

$waterMarkImg = Image::make('./img/watermark.png')
    ->resize(150, null, function (\Intervention\Image\Constraint $constraint) {
        $constraint->aspectRatio();
    });

$waterMarkImg->save('./img/new_watermark.jpg');

$img = Image::make('./img/cat.jpg')
    ->resize(500, null, function (\Intervention\Image\Constraint $constraint) {
        $constraint->aspectRatio();
    });
/*
$img->text('WaterMark', $img->getWidth() - 10, $img->getHeight() - 10, function($font) {
    $font->file(PUBLIC_DIR . 'fonts/Atlane-PK3r7.otf');
    $font->size(25);
    $font->color('#bcf5bc');
    $font->align('right');
    $font->valign('bottom');
});
*/

$img->insert('./img/new_watermark.jpg', 'bottom-right', 10, 10)
    ->save('./img/watermarked_cat.jpeg');

echo $img->response('jpg');
