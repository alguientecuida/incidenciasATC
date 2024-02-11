<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Models\USUARIO;

class MailVT extends Notification
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
        
        if($this->data['Estado'] == 'A'){
            $tecnico = USUARIO::find($this->data['tecnico']);
            $fecha = Carbon::parse($this->data['fecha']); // Asegúrate de ajustar esto según tu modelo y campo de fecha

            $fechaFormateada = $fecha->format('d/m/Y');
            if($this->data['externo'] == 'no'){
                return (new MailMessage)
                            ->subject('Se agendó una visita técnica para la Sucursal')
                            ->line("La fecha para la visita técnica es: {$fechaFormateada}")
                            ->line("El técnico encargado de realizarla es: {$tecnico->NOMBRE}")
                            ->salutation('Alguien Te Cuida SpA');
            }elseif($this->data['externo'] == 'si'){
                return (new MailMessage)
                            ->subject('Se agendó una visita técnica para la Sucursal')
                            ->line("La fecha para la visita técnica es: {$fechaFormateada}")
                            ->line("Debido a la distancia de su instalación con el alcance inmediato de nuestros tecnicos se asignó un técnico externo, el jefe del área técnica se mantendrá en contacto con usted")
                            ->salutation('Alguien Te Cuida SpA');
            }
        }elseif($this->data['Estado'] == 'EC'){
            return (new MailMessage)
                        ->subject('El técnico va en camino')
                        ->line('Notificamos que el técnico ya se encuentra en camino')
                        ->line('Por favor mantenerse atento a su celular o notificar a la persona que lo resivirá')
                        ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data['Estado'] == 'EP'){
            return (new MailMessage)
                        ->subject('El técnico ya llegó')
                        ->line('Notificamos que el técnico ya se encuentra en la instalación')
                        ->line('Inicio el trabajo, se le notificará una vez terminado')
                        ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data['Estado'] == 'F'){
            $persona_recibe = $this->data['nombre_recibe'];
            $fecha = Carbon::parse($this->data['fecha']); // Asegúrate de ajustar esto según tu modelo y campo de fecha

            $fechaFormateada = $fecha->format('d/m/Y');
            return (new MailMessage)
                        ->subject('El técnico ya finalizó')
                        ->line("Notificamos que los trabajos en la instalación han finalizado con fecha de: {$fechaFormateada}")
                        ->line("La persona que recibio el cierre de la Visita Técnica fue: {$persona_recibe}")
                        ->salutation('Alguien Te Cuida SpA');
        }elseif($this->data['Estado'] == 'R'){
            $tecnico = USUARIO::find($this->data['tecnico']);

            return (new MailMessage)
                        ->subject('Se reasignó el técnico encargado de la visita técnica para la Sucursal')
                        ->line("El nuevo técnico asignado a cargo de realizar la visita técnica es: {$tecnico->NOMBRE}")
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
