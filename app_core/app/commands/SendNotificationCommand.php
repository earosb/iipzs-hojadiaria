<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class SendNotificationCommand extends Command
{
    /**
     * Envía una notificación por email de los trabajos que se encuentran por vencer, a los usuarios con permiso programar
     *
     * $ /usr/bin/php-cli /home/icilicaf/app_core/artisan email:send
     */

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'programar:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia una notificacion de trabajos por vencer.';

    /**
     * Create a new command instance.
     * SendNotificationCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'programa.trabajo_id')
            ->where('vencimiento', '<', Carbon::now()->addWeeks(2))
            ->where('realizado', false)
            ->orderBy('vencimiento')
            ->get(['causa', 'nombre', 'km_inicio', 'km_termino', 'cantidad', 'vencimiento']);

        foreach ($trabajos as $trabajo) {
            $trabajo->vencimiento = Carbon::parse($trabajo->vencimiento)->format('d/m/Y');
        }

        if (0 < $trabajos->count()) {
            $users = Sentry::findAllUsers();
            foreach ($users as $user) {
                if ($user->hasAccess(['programar'])) {
                    Mail::send('emails.programar', ['user' => $user, 'trabajos' => $trabajos], function ($message) use ($user) {
                        $message->to($user->email, $user->username)->subject('Aviso de trabajos por vencer');
                    });
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('example', InputArgument::OPTIONAL, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
