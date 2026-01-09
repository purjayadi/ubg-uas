<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant;
use GuzzleHttp\Client;

class GeocodeRestaurants extends Command
{
    protected $signature = 'restaurants:geocode {--force : Overwrite existing coordinates}';
    protected $description = 'Batch geocode restaurant addresses using Nominatim (OpenStreetMap)';

    public function handle()
    {
        $this->info('Starting geocode for restaurants...');

        $query = Restaurant::query();
        if (! $this->option('force')) {
            $query->whereNull('latitude')->orWhereNull('longitude');
        }

        $restaurants = $query->get();
        $this->info('Found ' . $restaurants->count() . ' restaurants to geocode.');

        $client = new Client([
            'base_uri' => 'https://nominatim.openstreetmap.org',
            'headers' => [
                'User-Agent' => 'RevResto-App/1.0 (your-email@example.com)'
            ],
            'timeout' => 10,
        ]);

        $done = 0;
        foreach ($restaurants as $restaurant) {
            $address = trim($restaurant->address);
            if (! $address) {
                $this->warn("Skipping #{$restaurant->id}: empty address");
                continue;
            }

            $this->line("Geocoding #{$restaurant->id} - {$restaurant->name}...");
            try {
                $res = $client->get('/search', [
                    'query' => [
                        'format' => 'json',
                        'q' => $address,
                        'limit' => 1,
                    ],
                ]);

                $data = json_decode($res->getBody()->getContents(), true);
                if (! empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
                    $lat = (float) $data[0]['lat'];
                    $lon = (float) $data[0]['lon'];

                    $restaurant->latitude = $lat;
                    $restaurant->longitude = $lon;
                    $restaurant->save();

                    $this->info(" => OK: {$lat}, {$lon}");
                    $done++;
                } else {
                    $this->warn(' => No result');
                }

                // Respectful delay for Nominatim usage policy
                sleep(1);
            } catch (\Exception $e) {
                $this->error(' => Error: ' . $e->getMessage());
                // wait a bit before next attempt
                sleep(1);
            }
        }

        $this->info("Finished. Geocoded: {$done} restaurants.");
        return 0;
    }
}
