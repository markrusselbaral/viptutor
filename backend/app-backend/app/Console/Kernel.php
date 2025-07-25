protected function schedule(Schedule $schedule): void
{
    $schedule->command('tasks:cleanup')->dailyAt('00:00');
}
