<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
class AdminController extends Controller
{
    /**
     * Muestra el dashboard principal para el Administrador.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        // Cargar estadísticas generales de la aplicación y el sistema.

        return view('admin.dashboard', compact('user'));
    }

    public function iotDashboard()
    {
        // Puedes enviar datos de sensores o alertas si los tienes
        // Por ahora, solo muestra la vista
        return view('admin.iot_dashboard');
    }


    /**
     * Muestra la vista de configuración avanzada del sistema (ej. logs, ajustes de mail).
     */
    public function config(): View
    {
        return view('admin.config');
    }
    /**
     * Muestra la página principal de configuración avanzada
     */
    public function index()
    {
        // Config general
        $configGeneral = DB::table('config')->where('section', 'general')->pluck('value', 'key')->toArray();

        // Config Arduino
        $arduino = DB::table('config')->where('section', 'arduino')->pluck('value', 'key')->toArray();

        // Config SMTP
        $smtp = DB::table('config')->where('section', 'smtp')->pluck('value', 'key')->toArray();

        // Tablas DB y conteo de registros
        $tables = DB::select('SHOW TABLES');
        $dbTables = [];
        $dbName = env('DB_DATABASE');
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $dbName};
            $dbTables[$tableName] = DB::table($tableName)->count();
        }

        // PHP config
        $phpConfig = [
            'memory_limit' => ini_get('memory_limit'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_execution_time' => ini_get('max_execution_time'),
        ];

        // Pasamos a la vista solo lo necesario
        return view('admin.config', compact('configGeneral', 'dbTables', 'phpConfig', 'arduino', 'smtp'));
    }


    /**
     * Guarda configuración general, Arduino y SMTP
     */
    public function save(Request $request)
    {
        // Config General
        $general = $request->input('general', []);
        foreach ($general as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['key' => $key, 'section' => 'general'],
                ['value' => $value]
            );
        }

        // Config Arduino
        $arduino = $request->input('arduino', []);
        foreach ($arduino as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['key' => $key, 'section' => 'arduino'],
                ['value' => $value]
            );
        }

        // Config SMTP
        $smtp = $request->input('smtp', []);
        foreach ($smtp as $key => $value) {
            DB::table('config')->updateOrInsert(
                ['key' => $key, 'section' => 'smtp'],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.config')->with('success', 'Configuración guardada correctamente.');
    }

    /**
     * Test de conexión a la base de datos
     */
    public function testDB()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['message' => '✅ Conexión a base de datos exitosa']);
        } catch (\Exception $e) {
            return response()->json(['message' => '❌ Error al conectar a la base de datos: ' . $e->getMessage()]);
        }
    }

    /**
     * Enviar alerta de prueba de Arduino al correo configurado
     */
    public function testArduinoMail(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json(['message' => '❌ Debes ingresar un correo válido'], 422);
        }

        $arduinoConfig = DB::table('config')->where('section', 'arduino')->pluck('value', 'key')->toArray();
        $smtpConfig = DB::table('config')->where('section', 'smtp')->pluck('value', 'key')->toArray();

        // Configuración temporal de mail
        config([
            'mail.mailers.smtp.host' => $smtpConfig['host'] ?? env('MAIL_HOST'),
            'mail.mailers.smtp.port' => $smtpConfig['port'] ?? env('MAIL_PORT'),
            'mail.mailers.smtp.username' => $smtpConfig['user'] ?? env('MAIL_USERNAME'),
            'mail.mailers.smtp.password' => $smtpConfig['pass'] ?? env('MAIL_PASSWORD'),
            'mail.mailers.smtp.encryption' => 'tls',
            'mail.from.address' => $smtpConfig['user'] ?? env('MAIL_FROM_ADDRESS'),
            'mail.from.name' => 'BioTrack Alerta',
        ]);

        try {
            Mail::raw(
                "ALERTA DE PRUEBA: Se detectó un animal hostil (simulado). Umbral: {$arduinoConfig['distance_threshold']} cm",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Alerta Arduino - BioTrack');
                }
            );
            return response()->json(['message' => "✅ Alerta de prueba enviada a $email"]);
        } catch (\Exception $e) {
            return response()->json(['message' => '❌ Error enviando correo: ' . $e->getMessage()], 500);
        }
    }
}
