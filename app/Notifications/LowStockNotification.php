<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    use Queueable;
    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alerta de Stock Bajo 🚨')
            ->line("El producto {$this->product->name} ha alcanzado un stock bajo de {$this->product->stock} (mínimo: {$this->product->min_stock}).")
            ->action('Ver Producto', url('/admin/product/' . $this->product->id))
            ->line('Por favor, considera reabastecer el inventario. 📦');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'stock' => $this->product->stock,
            'stock_minimo' => $this->product->min_stock,
            'message' => "El producto {$this->product->name} ha alcanzado un stock bajo de {$this->product->stock} (mínimo: {$this->product->min_stock}).",
        ];
    }

    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
