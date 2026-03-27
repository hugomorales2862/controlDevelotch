<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa todas las suscripciones y suspende las que ya pasaron su fecha de vencimiento.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSubscriptions = Subscription::where('status', 'active')
            ->whereDate('end_date', '<', Carbon::now())
            ->get();

        $count = $expiredSubscriptions->count();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->status = 'suspended';
            $subscription->save();
        }

        $this->info("Se han suspendido {$count} suscripciones vencidas correctamente.");
    }
}
