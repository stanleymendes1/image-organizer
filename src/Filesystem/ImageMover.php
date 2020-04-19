<?php
namespace CViniciusSDias\ImageOrganizer\Filesystem;

class ImageMover
{
    public function move(\SplFileInfo $image, string $baseDir, string $fileName = null): bool
    {
        $mTime = $image->getMTime();
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($mTime);
        $year = $dateTime->format('Y');
        $month = $dateTime->format('m');
        $time = $dateTime->format('H-i-s');
        $destinyDirectory = "$baseDir/$year/$month";

        $name = $image->getFilename();

        if($fileName)
        {
            $name = $fileName . '_' . $time;
        }

        if (!file_exists($destinyDirectory)) {
            mkdir($destinyDirectory, 0777, true);
        }

        return rename($image->getRealPath(), $destinyDirectory . '/' . $name);
    }
}
