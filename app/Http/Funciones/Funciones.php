<?php

use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Eye\CompositeEye;
use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

function qrCodeGenerate(?string $content = null, ?int $size = null, ?int $margin = null, ?string $filename = null, ?string $encoding = null, ?array $backgroundColor = null, ?array $foregroundColor = null, ?string $path = null): string
{
    $content = $content ?? 'Hello World!';
    $size = $size ?? 400;
    $margin = $margin ?? 4;
    $path = $path ? 'storage/'.$path.'/' : 'storage/images-qr/';
    $filename = $filename ? Str::slug($filename) : 'qrcode';
    $encoding = $encoding ?? Encoder::DEFAULT_BYTE_MODE_ECODING;

    $backgroundColorRed = 255;
    $backgroundColorGreen = 255;
    $backgroundColorBlue = 255;

    $foregroundColorRed = 0;
    $foregroundColorGreen = 0;
    $foregroundColorBlue = 0;

    if (! empty($backgroundColor)) {
        $backgroundColorRed = $backgroundColor[0] ?? $backgroundColorRed;
        $backgroundColorGreen = $backgroundColor[1] ?? $backgroundColorGreen;
        $backgroundColorBlue = $backgroundColor[2] ?? $backgroundColorBlue;
    }

    if (! empty($foregroundColor)) {
        $foregroundColorRed = $foregroundColor[0] ?? $foregroundColorRed;
        $foregroundColorGreen = $foregroundColor[1] ?? $foregroundColorGreen;
        $foregroundColorBlue = $foregroundColor[2] ?? $foregroundColorBlue;
    }

    if (! extension_loaded('imagick')) {
        $imageBackEnd = new SvgImageBackEnd;
        $extension = '.svg';
    } else {
        $imageBackEnd = new ImagickImageBackEnd;
        $extension = '.png';
    }

    $module = new RoundnessModule(RoundnessModule::SOFT);
    $eye = new CompositeEye(SimpleCircleEye::instance(), SquareEye::instance());

    $renderer = new ImageRenderer(
        new RendererStyle(
            $size,
            $margin,
            $module,
            $eye,
            Fill::uniformColor(
                backgroundColor: new Rgb($backgroundColorRed, $backgroundColorGreen, $backgroundColorBlue),
                foregroundColor: new Rgb($foregroundColorRed, $foregroundColorGreen, $foregroundColorBlue)
            )
        ),
        imageBackEnd: $imageBackEnd,
    );
    $write = new Writer($renderer);
    $write->writeFile($content, $path.$filename.$extension, $encoding);

    return asset($path.$filename.$extension);

}

/*function qrCodeGenerateFPDF(?string $content = null, ?int $size = null, ?int $margin = null, ?string $filename = null, ?string $encoding = null, ?array $backgroundColor = null, ?array $foregroundColor = null, ?string $path = null): string
{
    if (! extension_loaded('imagick')) {

        $content = $content ?? 'Hello World!';
        $size = $size ?? 400;
        $path = $path ? 'storage/'.$path.'/' : 'storage/images-qr/';
        $filename = $filename ? Str::slug($filename) : 'qrcode';

        $renderer = new GDLibRenderer($size);
        $writer = new Writer($renderer);
        $writer->writeFile($content, $path.$filename.'.png');

        return asset($path.$filename.'.png');

    } else {
        return qrCodeGenerate($content, $size, $margin, $filename, $encoding, $backgroundColor, $foregroundColor, $path);
    }
}*/
