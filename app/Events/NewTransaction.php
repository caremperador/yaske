<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTransaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $transaction;
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
        $this->transaction->load('buyer'); // Carga la relación del comprador
        // Asegúrate de que la transacción tenga los detalles necesarios
        $this->transaction->metodo_pago = $transaction->metodo_pago;
        $this->transaction->cantidad_dias = $transaction->cantidad_dias;
        $this->transaction->monto_total = $transaction->monto_total;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // En tu evento de broadcasting
    public function broadcastOn()
    {
        return new PrivateChannel('transactions.' . $this->transaction->seller_id);
    }
    public function broadcastWith()
    {
        return [
            'transaction' => [
                'id' => $this->transaction->id,
                'buyer_id' => $this->transaction->buyer->id,
                'buyer_name' => $this->transaction->buyer->name, // Asegúrate de que el comprador está cargado
                'seller_id' => $this->transaction->seller_id,
                'photo_path' => $this->transaction->photo_path,
                'created_at' => $this->transaction->created_at,
                'updated_at' => $this->transaction->updated_at,
                'metodo_pago' => $this->transaction->metodo_pago,
                'cantidad_dias' => $this->transaction->cantidad_dias,
                'monto_total' => $this->transaction->monto_total,
            ],
        ];
    }
}