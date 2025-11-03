<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    /** Dashboard principal del Admin */
    public function dashboard(): View
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    /** Panel de configuración IoT / Arduino */
    public function iotDashboard(): View
    {
        // Cargar datos de configuración desde la BD
        $configGeneral = DB::table('config')->where('section', 'general')->pluck('value', 'key')->toArray();
        $arduino = DB::table('config')->where('section', 'arduino')->pluck('value', 'key')->toArray();
        $smtp = DB::table('config')->where('section', 'smtp')->pluck('value', 'key')->toArray();

        // Valores por defecto si faltan
        $arduino = array_merge([
            'distance_threshold' => 50,
            'alert_cooldown_ms' => 30000,
            'use_custom_mail' => $arduino['use_custom_mail'] ?? 'no',
        ], $arduino);

        $smtp = array_merge([
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'user' => '',
            'pass' => '',
            'encryption' => 'ssl',
            'test_email' => '',
        ], $smtp);

        return view('admin.iot_dashboard', compact('configGeneral', 'arduino', 'smtp'));
    }

    /** Guarda configuración general, Arduino y SMTP */
    public function save(Request $request)
    {
        $request->validate([
            'smtp.user' => 'required|email',
            'smtp.pass' => 'required|string',
            'smtp.host' => 'required|string',
            'smtp.port' => 'required|numeric',
            'smtp.test_email' => 'required|email',
        ]);

        foreach ($request->input('general', []) as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['section' => 'general', 'key' => $key],
                ['value' => $value]
            );
        }

        foreach ($request->input('arduino', []) as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['section' => 'arduino', 'key' => $key],
                ['value' => $value]
            );
        }

        foreach ($request->input('smtp', []) as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['section' => 'smtp', 'key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.iot')->with('success', 'Configuración IoT guardada correctamente.');
    }

    /** Cambiar método de envío IoT (correo de .env o configurado) */
    public function toggleMailMethod(Request $request)
    {
        $mode = $request->input('mode', 'no'); // 'yes' = usar configurado, 'no' = usar .env

        DB::table('config')->updateOrInsert(
            ['section' => 'arduino', 'key' => 'use_custom_mail'],
            ['value' => $mode]
        );

        return back()->with('success', 'Método de correo actualizado.');
    }

    /** Enviar correo de prueba desde Arduino / IoT */
    public function testArduinoMail(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json(['message' => '❌ Debes ingresar un correo válido'], 422);
        }

        $arduinoConfig = DB::table('config')->where('section', 'arduino')->pluck('value', 'key')->toArray();
        $smtpConfig = DB::table('config')->where('section', 'smtp')->pluck('value', 'key')->toArray();
        $useCustom = $arduinoConfig['use_custom_mail'] ?? 'no';

        if ($useCustom === 'yes') {
            config([
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $smtpConfig['host'] ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $smtpConfig['port'] ?? 465,
                'mail.mailers.smtp.username' => $smtpConfig['user'] ?? env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => $smtpConfig['pass'] ?? env('MAIL_PASSWORD'),
                'mail.mailers.smtp.encryption' => $smtpConfig['encryption'] ?? 'ssl',
                'mail.from.address' => $smtpConfig['user'] ?? env('MAIL_FROM_ADDRESS'),
                'mail.from.name' => 'BioTrack Alerta',
            ]);
        }

        try {
            Mail::raw(
                "✅ Correo de prueba enviado desde BioTrack.\n\nModo actual: " . ($useCustom === 'yes' ? 'Correo configurado manualmente' : 'Correo por defecto (.env)') .
                "\n\nUmbral actual: " . ($arduinoConfig['distance_threshold'] ?? '50') . " cm",
                function ($message) use ($email) {
                    $message->to($email)->subject('Prueba de Alerta - BioTrack');
                }
            );
            return response()->json(['message' => "✅ Correo de prueba enviado a $email"]);
        } catch (\Exception $e) {
            return response()->json(['message' => '❌ Error enviando correo: ' . $e->getMessage()], 500);
        }
    }

    /** Endpoint JSON para Python (Arduino) */
    public function apiArduinoConfig()
    {
        $arduino = DB::table('config')->where('section', 'arduino')->pluck('value', 'key')->toArray();
        $smtp = DB::table('config')->where('section', 'smtp')->pluck('value', 'key')->toArray();

        return response()->json(array_merge($arduino, ['smtp' => $smtp]));
    }

    /** Vista flujo de correo / alertas */
    public function flujoCorreo()
    {
        return view('admin.flujocorreo');
    }

    /** Configuración del sistema web (mantenimiento) */
    public function config()
    {
        return view('admin.config');
    }

    /** Limpia cachés de configuración, rutas y vistas */
    public function clearCache()
    {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        return back()->with('success', '✅ Caché limpiada correctamente.');
    }

    /** Regenera APP_KEY de Laravel */
    public function regenerateKey()
    {
        \Artisan::call('key:generate', ['--force' => true]);
        return back()->with('success', '🔑 APP_KEY regenerada exitosamente.');
    }

    /** Actualiza el Service Worker manualmente (si aplica) */
    public function updateServiceWorker()
    {
        $path = public_path('sw.js');
        if (file_exists($path)) {
            file_put_contents($path, file_get_contents($path) . "\n// Actualizado " . now());
            return back()->with('success', '⚙️ Service Worker actualizado.');
        }
        return back()->with('error', '❌ No se encontró el archivo sw.js');
    }

    /** Verifica estado general del sistema */
    public function checkStatus()
    {
        $dbConnected = false;
        try {
            \DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            $dbConnected = false;
        }

        return back()->with('success', $dbConnected ? '✅ Base de datos conectada correctamente.' : '⚠️ Error de conexión a la base de datos.');
    }
}
