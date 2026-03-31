<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Application;
use App\Models\Service;
use App\Models\Subscription;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Aplicaciones
        $app1 = Application::create([
            'name' => 'Portal de Clientes v2.0',
            'description' => 'Acceso exclusivo para clientes de Develotech.',
            'url' => 'https://portal.develotech.com',
            'status' => 'active',
        ]);

        $app2 = Application::create([
            'name' => 'API Enterprise',
            'description' => 'Servicios REST para integración de terceros.',
            'url' => 'https://api.develotech.com',
            'status' => 'active',
        ]);

        // 2. Servicios
        $serv1 = Service::create([
            'name' => 'Hosting VPS Pro - 8GB RAM',
            'price' => 45.00,
            'duration_days' => 30,
            'features' => json_encode(['8GB RAM', '4 vCPU', '160GB SSD', 'Snapshots semanales']),
        ]);

        $serv2 = Service::create([
            'name' => 'Mantenimiento Correctivo Mensual',
            'price' => 150.00,
            'duration_days' => 30,
            'features' => json_encode(['Soporte 24/7', 'Parches de seguridad', 'Optimización DB']),
        ]);

        $serv3 = Service::create([
            'name' => 'Backup Cloud Empresarial',
            'price' => 25.00,
            'duration_days' => 30,
            'features' => json_encode(['Encriptación AES-256', '500GB espacio', 'Retención 1 año']),
        ]);

        // 3. Clientes
        $client1 = Client::create([
            'name' => 'Tech Innovators Inc.',
            'company' => 'Tech Innovators Global',
            'email' => 'contact@techinnovators.com',
            'phone' => '+1 555-010-999',
            'nit' => '99887766-5',
            'razon_social' => 'Tech Innovators Global S.A.',
            'metadata' => json_encode(['sector' => 'Fintech', 'tamaño' => 'Mediana']),
        ]);

        $client2 = Client::create([
            'name' => 'Soluciones Digitales Latam',
            'company' => 'Grupo Soluciones Latam',
            'email' => 'info@solucioneslatam.net',
            'phone' => '+502 2233-4455',
            'nit' => '11223344-K',
            'razon_social' => 'Soluciones Digitales de Centroamérica, S.A.',
            'metadata' => json_encode(['sector' => 'Retail', 'tamaño' => 'Grande']),
        ]);

        // 4. Suscripciones (Validación de lógica de fechas)
        Subscription::create([
            'client_id' => $client1->cli_id,
            'service_id' => $serv1->id,
            'amount' => 45.00,
            'billing_cycle' => 'monthly',
            'status' => 'active',
            'start_date' => Carbon::now()->subDays(15), // Mitad del ciclo
        ]);

        Subscription::create([
            'client_id' => $client1->cli_id,
            'service_id' => $serv2->id,
            'amount' => 150.00,
            'billing_cycle' => 'yearly',
            'status' => 'active',
            'start_date' => Carbon::now()->subMonths(2), 
        ]);

        Subscription::create([
            'client_id' => $client2->cli_id,
            'service_id' => $serv1->id,
            'amount' => 45.00,
            'billing_cycle' => 'monthly',
            'status' => 'active',
            'start_date' => Carbon::now()->subDays(2), 
        ]);
        
        Subscription::create([
            'client_id' => $client2->cli_id,
            'service_id' => $serv3->id,
            'amount' => 25.00,
            'billing_cycle' => 'triennial',
            'status' => 'active',
            'start_date' => Carbon::now()->subYears(1), 
        ]);
    }
}
