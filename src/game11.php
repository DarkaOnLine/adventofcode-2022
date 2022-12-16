<?php

declare(strict_types=1);

namespace DarkaOnLine\AdventOfCode2022;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Game11 extends Command
{
    protected static $defaultName = 'game:11';

    protected string $inputData = 'Monkey 0:
  Starting items: 89, 74
  Operation: new = old * 5
  Test: divisible by 17
    If true: throw to monkey 4
    If false: throw to monkey 7

Monkey 1:
  Starting items: 75, 69, 87, 57, 84, 90, 66, 50
  Operation: new = old + 3
  Test: divisible by 7
    If true: throw to monkey 3
    If false: throw to monkey 2

Monkey 2:
  Starting items: 55
  Operation: new = old + 7
  Test: divisible by 13
    If true: throw to monkey 0
    If false: throw to monkey 7

Monkey 3:
  Starting items: 69, 82, 69, 56, 68
  Operation: new = old + 5
  Test: divisible by 2
    If true: throw to monkey 0
    If false: throw to monkey 2

Monkey 4:
  Starting items: 72, 97, 50
  Operation: new = old + 2
  Test: divisible by 19
    If true: throw to monkey 6
    If false: throw to monkey 5

Monkey 5:
  Starting items: 90, 84, 56, 92, 91, 91
  Operation: new = old * 19
  Test: divisible by 3
    If true: throw to monkey 6
    If false: throw to monkey 1

Monkey 6:
  Starting items: 63, 93, 55, 53
  Operation: new = old * old
  Test: divisible by 5
    If true: throw to monkey 3
    If false: throw to monkey 1

Monkey 7:
  Starting items: 50, 61, 52, 58, 86, 68, 97
  Operation: new = old + 4
  Test: divisible by 11
    If true: throw to monkey 5
    If false: throw to monkey 4';

    protected string $inputTest = 'Monkey 0:
  Starting items: 79, 98
  Operation: new = old * 19
  Test: divisible by 23
    If true: throw to monkey 2
    If false: throw to monkey 3

Monkey 1:
  Starting items: 54, 65, 75, 74
  Operation: new = old + 6
  Test: divisible by 19
    If true: throw to monkey 2
    If false: throw to monkey 0

Monkey 2:
  Starting items: 79, 60, 97
  Operation: new = old * old
  Test: divisible by 13
    If true: throw to monkey 1
    If false: throw to monkey 3

Monkey 3:
  Starting items: 74
  Operation: new = old + 3
  Test: divisible by 17
    If true: throw to monkey 0
    If false: throw to monkey 1';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $partOne = [];
        $roundsAmount = 20;

        $partTwo = [];
//        $roundsAmount = 10000;

        $monkeys = [];
        $monkeyKey = 0;
        $monkeys[$monkeyKey]['hits'] = 0;

        foreach (explode(PHP_EOL, $this->inputData) as $line) {
            $line = trim($line);
            if ($line === '') {
                $monkeyKey++;
                $monkeys[$monkeyKey]['hits'] = 0;
                continue;
            }

            if (str_starts_with($line, 'Monkey')) {
                continue;
            }

            if (str_starts_with($line, 'Starting items: ')) {
                $items = explode(', ', explode('Starting items: ', $line)[1]);
                $monkeys[$monkeyKey]['items'] = $items;
                continue;
            }

            if (str_starts_with($line, 'Operation: ')) {
                $monkeys[$monkeyKey]['operation'] = explode('new = ', explode('Operation: ', $line)[1])[1];
                continue;
            }

            if (str_starts_with($line, 'Test: ')) {
                $monkeys[$monkeyKey]['test'] = explode('divisible by ', explode('Test: ', $line)[1])[1];
                continue;
            }

            if (str_starts_with($line, 'If true: ')) {
                $monkeys[$monkeyKey]['if'][true] = explode('throw to monkey ', explode('If true: ', $line)[1])[1];
                continue;
            }

            if (str_starts_with($line, 'If false: ')) {
                $monkeys[$monkeyKey]['if'][false] = explode('throw to monkey ', explode('If false: ', $line)[1])[1];
                continue;
            }
        }

        for ($round = 0; $round < $roundsAmount; $round++) {
            for ($i = 0; $i < count($monkeys); $i++) {
                foreach ($monkeys[$i]['items'] as $itemK => $item) {
                    $monkeys[$i]['hits']++;

                    $math = explode(' ', str_replace('old', $item, $monkeys[$i]['operation']));

                    $worryLevel = false;

                    if ($math[1] === '+') {
                        $worryLevel = floor(((int)$math[0] + (int)$math[2]) / 3);
                    } elseif ($math[1] === '*') {
                        $worryLevel = floor(((int)$math[0] * (int)$math[2]) / 3);
                    } else {
                        dd('Miss');
                    }

                    $test = ($worryLevel % $monkeys[$i]['test'] === 0);
                    $moveTo = $monkeys[$i]['if'][$test];
                    $monkeys[$moveTo]['items'][] = (string) $worryLevel;
                    unset($monkeys[$i]['items'][$itemK]);
                }
            }
        }

        dump('Part One:', ($partOne));
        dd('Part Two:', ($partTwo));

    }
}
