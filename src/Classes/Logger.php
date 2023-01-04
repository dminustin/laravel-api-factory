<?php

namespace Dminustin\ApiFactory\Classes;

class Logger extends \Illuminate\Log\Logger
{
    protected function writeLog($level, $message, $context): void
    {
        if ($level == 'info') {
            $message = $this->formatGreen($message);
        } elseif ($level == 'warning') {
            $message = $this->formatYellow($message);
        } else {
            $message = $this->formatGreen($message);
        }
        $messageFormatted = sprintf(
            '%s: %s',
            $this->formatYellowBG($level),
            $message
        );
        echo $messageFormatted . PHP_EOL;
    }

    protected function formatGreen($message): string
    {
        return "\033[92m" . $message . "\033[0m";
    }

    protected function formatYellow($message): string
    {
        return "\033[33m" . $message . "\033[0m";
    }

    protected function formatYellowBG($message): string
    {
        return "\033[1;103m" . $message . "\033[0m";
    }

    protected function formatRed($message): string
    {
        return "\033[91m" . $message . "\033[0m";
    }
}
