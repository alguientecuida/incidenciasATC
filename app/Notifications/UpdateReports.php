<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateReports extends Notification
{
    use Queueable;


    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->data == 'DS'){
            return (new MailMessage)
                    ->subject('Se derivó un reporte a Soporte')
                    ->line('Un reporte fue derivado al área de Soporte.')
                    ->action('Revisar reportes', url('/reportes/derivados/soporte'))
                    ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data == 'DJT'){
            return (new MailMessage)
                    ->subject('Se derivó un reporte al Jefe Tecnico')
                    ->line('Un reporte fue derivado al área Técnica.')
                    ->action('Revisar reportes', url('/reportes/derivados/jefe/tecnicos'))
                    ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data == 'DT'){
            return (new MailMessage)
                        ->subject('Se asignó una orden de trabajo')
                        ->line('Una ordén de trabajo fue asiganda a tu nombre')
                        ->action('Revisar ODTS', url('/odts/tecnicos'))
                        ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data == 'R'){
            return (new MailMessage)
                        ->subject('Se reasignó una orden de trabajo')
                        ->line('Una ordén de trabajo fue reasiganda a tu nombre')
                        ->action('Revisar ODTS', url('/odts/tecnicos'))
                        ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data == 'DC'){
            return (new MailMessage)
                        ->subject('El problema lo debe de solucionar usted')
                        ->line('En nuestra revisión remota o en el lugar, nos percatamos que usted debe solucionar el problema.')
                        ->line('Por favor recuerde una vez solucionado su problema informar a la sala de operaciones o con soporte.')
                        ->salutation('Alguien Te Cuida SpA');
        }           
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
