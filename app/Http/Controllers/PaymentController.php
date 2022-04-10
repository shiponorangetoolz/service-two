<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            $response = Http::withToken($token)->post('http://auth.test/api/authenticate');
            if ($response->ok()) {
                $payment = Payment::find(1);

                if ($request->amount <= $payment->amount) {
                    DB::beginTransaction();

                    try {
                        $payment->update([
                            'amount' => $payment->amount - $request->amount
                        ]);
                        if (4 % 2 !== 0) {
                            throw new Exception('something went wrong');
                        }
                        DB::commit();

                        return response()->json($payment, Response::HTTP_ACCEPTED);
                    } catch (Exception $e) {
                        $e = $e->getMessage();
                        return response()->json(['error' => $e], Response::HTTP_EXPECTATION_FAILED);
                    }
                } else {
                    return response()->json(['message' => 'Balance is not sufficient'], Response::HTTP_NOT_ACCEPTABLE);
                }
            } else {
                return response()->json($response->body(), Response::HTTP_NOT_ACCEPTABLE);
            }
        } else {
            return response()->json(['error' => 'Access token expired'], Response::HTTP_FORBIDDEN);
        }
    }
}
