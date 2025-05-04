<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageWidth = 800;
        $imageHeight = 600;
        $imagePath = $this->generateAndSaveImage('posts', $imageWidth, $imageHeight);

        return [
            'body' => fake()->text(800),
            'user_id' => User::query()->inRandomOrder()->first(),
            'title' => fake()->text(30),
            'photo_path' => $imagePath,
        ];
    }

    protected function generateAndSaveImage(string $folder, int $width, int $height): string
    {
        $image = imagecreatetruecolor($width, $height);

        $startColor = [rand(0, 255), rand(0, 255), rand(0, 255)];
        $endColor = [rand(0, 255), rand(0, 255), rand(0, 255)];

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $red = $startColor[0] + ($endColor[0] - $startColor[0]) * $ratio;
            $green = $startColor[1] + ($endColor[1] - $startColor[1]) * $ratio;
            $blue = $startColor[2] + ($endColor[2] - $startColor[2]) * $ratio;

            $lineColor = imagecolorallocate($image, $red, $green, $blue);
            imageline($image, 0, $y, $width, $y, $lineColor);
        }

        $textColor = imagecolorallocate($image, 255, 255, 255);
        $text = substr(fake()->sentence(3), 0, 30);
        $fontSize = 5;

        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $centerX = ($width - $textWidth) / 2;
        $centerY = ($height - $textHeight) / 2;

        imagestring($image, $fontSize, $centerX, $centerY, $text, $textColor);

        $borderColor = imagecolorallocate($image, 255, 255, 255);
        imagerectangle($image, 10, 10, $width - 10, $height - 10, $borderColor);

        $tmpFile = tempnam(sys_get_temp_dir(), 'img');
        imagepng($image, $tmpFile);
        imagedestroy($image);

        $fileName = $folder . '/' . uniqid('post_', true) . '.png';

        $filePath = Storage::disk('public')->putFileAs(
            $folder,
            $tmpFile,
            basename($fileName)
        );

        unlink($tmpFile);

        return $filePath;
    }
}
