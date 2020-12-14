<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Prestamo;
use App\Articulo;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            error_log('comesando el trabajo');
            $prestamos = Prestamo::All();
            foreach($prestamos as $prestamo){
                    if($prestamo->Fecha_entregado){
                        $semanas =Carbon::now()->diffInWeeks($prestamo->Fecha_entrega);
                        if($semanas >= 2){
                            $articulo_id = $prestamo->articulo_id;
                            $articulo = Articulo::find($articulo_id);
                            $articulo->utilizable = false;
                            $articulo->save();                     
                        }
                    }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
