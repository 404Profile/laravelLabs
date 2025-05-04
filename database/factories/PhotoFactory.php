<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageWidth = 640;
        $imageHeight = 480;
        $imagePath = $this->generateAndSaveImage('images', $imageWidth, $imageHeight);

        return [
            'title' => fake()->realText(100),
            'photo_path' => $imagePath,
        ];
    }

    protected function generateAndSaveImage(string $folder, int $width, int $height): string
    {
        $image = imagecreatetruecolor($width, $height);

        $bgColor = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
        $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

        imagefill($image, 0, 0, $bgColor);

        $text = fake()->word();
        $fontSize = 5;

        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $centerX = ($width - $textWidth) / 2;
        $centerY = ($height - $textHeight) / 2;

        imagestring($image, $fontSize, $centerX, $centerY, $text, $textColor);

        for ($i = 0; $i < 10; $i++) {
            $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline(
                $image,
                rand(0, $width), rand(0, $height),
                rand(0, $width), rand(0, $height),
                $lineColor
            );
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'img');
        imagepng($image, $tmpFile);
        imagedestroy($image);

        $fileName = $folder . '/' . uniqid('photo_', true) . '.png';

        $filePath = Storage::disk('public')->putFileAs(
            $folder,
            $tmpFile,
            basename($fileName)
        );

        unlink($tmpFile);

        return $filePath;
    }
}
