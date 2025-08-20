<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\VerificationCodeMail;
use Throwable;

class EmailVerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $code = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        try {
            // Guardar en BD (asegúrate de tener $fillable en el modelo)
            EmailVerification::updateOrCreate(
                ['email' => $request->email],
                [
                    'code'       => $code,
                    'expires_at' => $expiresAt,
                    'is_verified'=> false
                ]
            );

            // Enviar correo usando el Mailable (puede lanzar excepción si SMTP falla)
            Mail::to($request->email)->send(new VerificationCodeMail(
                $code,
                $request->email,
                $expiresAt
            ));

            return response()->json([
                'success' => true,
                'message' => '✅ Código enviado con éxito. Revisa tu correo (incluido spam).',
                'expires_at' => $expiresAt->toDateTimeString()
            ]);
        } catch (Throwable $e) {
            // Log completo
            Log::error('Error sendCode: '.$e->getMessage(), [
                'exception' => $e,
                'email' => $request->email ?? null,
            ]);

            // Respuesta JSON con mensaje (en local es útil mostrar el error)
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al enviar el código.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function validateCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6'
        ]);

        $record = EmailVerification::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => '❌ Código inválido.'
            ], 400);
        }

        if ($record->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => '⏳ El código ha expirado, solicita uno nuevo.'
            ], 400);
        }

        $record->update(['is_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => '✅ Correo verificado exitosamente.'
        ]);
    }
}
