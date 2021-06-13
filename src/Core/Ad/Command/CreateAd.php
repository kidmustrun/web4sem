<?php

declare(strict_types=1);

namespace App\Core\Ad\Command;

use App\Core\Ad\Document\Ad;
use App\Core\Ad\Repository\AdRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAd extends Command
{
    protected static $defaultName = 'app:core:create-ad';

    private AdRepository $adRepository;

    public function __construct(AdRepository $adRepository)
    {
        parent::__construct();

        $this->adRepository = $adRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new ad.')
            ->setHelp('This command allows you to create a ad...')
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'Title')
            ->addOption('desc', null, InputOption::VALUE_REQUIRED, 'Description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($ad = $this->adRepository->findOneBy(['desc' => $input->getOption('desc')])) {
            $output->writeln(
                [
                    'Ad already exists!',
                    '============',
                    $this->formatAdLine($ad),
                ]
            );

            return Command::SUCCESS;
        }

        $ad = new Ad(
            $input->getOption('title'),
            $input->getOption('desc')
        );
        $ad->setTitle($input->getOption('title'));
        $ad->setDesc($input->getOption('desc'));

        $this->adRepository->save($ad);

        $output->writeln(
            [
                'Ad is created!',
                '============',
                $this->formatAdLine($ad),
            ]
        );

        return Command::SUCCESS;
    }

    private function formatAdLine(Ad $ad): string
    {
        return sprintf(
            'id: %s, title: %s, desc: %s',
            $ad->getId(),
            $ad->getTitle(),
            $ad->getDesc(),
        );
    }
}