<?php
namespace App\Services;
use App\Models\Obstacle;
use PhpMqtt\Client\MqttClient;
use Exception;
use Illuminate\Support\Facades\Log;

class IoTService
{
    protected $mqttClient;

    public function __construct()
    {
        try {
            $this->mqttClient = new MqttClient(
                env('MQTT_HOST', 'broker.hivemq.com'),
                env('MQTT_PORT', 1883),
                'laravel-client-' . uniqid()
            );
            $this->mqttClient->connect();
        } catch (Exception $e) {
            Log::error('MQTT Connection Failed: ' . $e->getMessage());
        }
    }

    public function subscribeToDevice($deviceId)
    {
        $topic = "visualimpairedassistance/devices/{$deviceId}/data";
        $this->mqttClient->subscribe($topic, function ($topic, $message) {
            try {
                $data = json_decode($message, true);
                Obstacle::create([
                    'device_id' => $data['device_id'] ?? null,
                    'distance' => $data['distance'] ?? null,
                    'type' => $data['type'] ?? null,
                    'latitude' => $data['latitude'] ?? null,
                    'longitude' => $data['longitude'] ?? null,
                    'detected_at' => now(),
                ]);
                Log::info("Saved obstacle data for device {$data['device_id']}");
            } catch (Exception $e) {
                Log::error("Failed to process MQTT message: {$e->getMessage()}");
            }
        });
    }

    public function publishToDevice($deviceId, $message)
    {
        $topic = "visualimpairedassistance/devices/{$deviceId}/commands";
        $this->mqttClient->publish($topic, $message);
    }

    public function __destruct()
    {
        if ($this->mqttClient) {
            $this->mqttClient->disconnect();
        }
    }
}