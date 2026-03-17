<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Categoria;
use App\Models\Transaccion;
use App\Models\Pago;
use Illuminate\Database\Seeder;

class VelotechSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categorías Financieras
        $catServidores = Categoria::create(['nombre' => 'Servidores', 'tipo' => 'egreso']);
        $catDominios = Categoria::create(['nombre' => 'Dominios', 'tipo' => 'egreso']);
        $catSuscripciones = Categoria::create(['nombre' => 'Suscripciones Software', 'tipo' => 'egreso']);
        $catIngresoProyectos = Categoria::create(['nombre' => 'Nuevos Proyectos', 'tipo' => 'ingreso']);
        $catIngresoMantenimiento = Categoria::create(['nombre' => 'Mantenimiento Mensual', 'tipo' => 'ingreso']);

        // 2. Clientes
        $cliente1 = Cliente::create([
            'nombre' => 'Juan Pérez',
            'empresa' => 'TecnoLogix S.A.',
            'telefono' => '555-0101',
            'email' => 'juan@tecnologix.com',
            'ciudad' => 'Ciudad de México',
            'pais' => 'México',
            'fecha_registro' => now()->subMonths(6),
            'estado' => 'activo'
        ]);

        $cliente2 = Cliente::create([
            'nombre' => 'María García',
            'empresa' => 'Distribuidora Norte',
            'telefono' => '555-0202',
            'email' => 'maria@distribuidora.com',
            'ciudad' => 'Monterrey',
            'pais' => 'México',
            'fecha_registro' => now()->subMonths(3),
            'estado' => 'activo'
        ]);

        // 3. Servicios
        $serv1 = Servicio::create([
            'cliente_id' => $cliente1->id,
            'nombre' => 'Hosting Premium + VPS',
            'tipo' => 'Hosting',
            'precio_mensual' => 1200.00,
            'dia_pago' => 5,
            'fecha_inicio' => now()->subMonths(6),
            'estado' => 'activo',
            'proveedor' => 'DigitalOcean',
            'dominio' => 'tecnologix.com'
        ]);

        $serv2 = Servicio::create([
            'cliente_id' => $cliente2->id,
            'nombre' => 'Desarrollo Web Personalizado',
            'tipo' => 'Desarrollo',
            'precio_mensual' => 2500.00,
            'dia_pago' => 15,
            'fecha_inicio' => now()->subMonths(3),
            'estado' => 'activo',
            'dominio' => 'distribuidowanorte.mx'
        ]);

        // 4. Pagos
        Pago::create([
            'cliente_id' => $cliente1->id,
            'servicio_id' => $serv1->id,
            'monto' => 1200.00,
            'fecha_vencimiento' => now()->subMonth(),
            'estado' => 'pagado',
            'fecha_pago' => now()->subMonth()->addDays(2),
            'metodo_pago' => 'Transferencia'
        ]);

        Pago::create([
            'cliente_id' => $cliente2->id,
            'servicio_id' => $serv2->id,
            'monto' => 2500.00,
            'fecha_vencimiento' => now()->addDays(5),
            'estado' => 'pendiente'
        ]);

        // 5. Transacciones (Finanzas)
        Transaccion::create([
            'tipo' => 'ingreso',
            'categoria_id' => $catIngresoMantenimiento->id,
            'descripcion' => 'Pago mensualidad TecnoLogix',
            'monto' => 1200.00,
            'fecha' => now()->subMonth()->addDays(2),
            'metodo_pago' => 'Transferencia'
        ]);

        Transaccion::create([
            'tipo' => 'egreso',
            'categoria_id' => $catServidores->id,
            'descripcion' => 'Factura mensual AWS / DigitalOcean',
            'monto' => 450.00,
            'fecha' => now()->subDays(10),
            'metodo_pago' => 'Tarjeta Crédito'
        ]);
    }
}
