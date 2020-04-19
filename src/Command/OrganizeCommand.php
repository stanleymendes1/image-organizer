<?php
namespace CViniciusSDias\ImageOrganizer\Command;

use CViniciusSDias\ImageOrganizer\Filesystem\ImageFinder;
use CViniciusSDias\ImageOrganizer\Filesystem\ImageMover;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrganizeCommand extends Command
{
    /**
     * @var ImageFinder
     */
    private $imageFinder;
    /**
     * @var ImageMover
     */
    private $imageMover;

    public function __construct(ImageFinder $imageFinder, ImageMover $imageMover)
    {
        parent::__construct('organize');

        $this->imageFinder = $imageFinder;
        $this->imageMover = $imageMover;
    }

    protected function configure()
    {
        $this
            ->setDescription('Organize your images by month and year')
            ->setProcessTitle('image-organizer')
            ->addArgument('directory', InputArgument::REQUIRED, 'Directory where to find images')
            ->addOption('file-name', null, InputArgument::OPTIONAL, 'Change the file name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('directory');
        $fileName = $input->getOption('file-name');
        $images = $this->imageFinder->find($directory);

        foreach ($images as $image) {
            $this->imageMover->move($image, $directory, $fileName);

            if($output->isVerbose())
            {
                $output->writeln('Image: ' . $image->getFilename() . ' moved with success!');
            }
        }

        return 0;
    }
}
