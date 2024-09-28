<?php

namespace App\Http\Controllers\Frontend;


use App\Enums\Activity;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Events\SendOrderGotMail;
use App\Events\SendOrderGotPush;
use App\Events\SendOrderGotSms;
use App\Events\SendOrderMail;
use App\Events\SendOrderPush;
use App\Events\SendOrderSms;
use App\Http\Requests\PaymentRequest;
use App\Libraries\AppLibrary;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\ThemeSetting;
use App\Services\PaymentManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Smartisan\Settings\Facades\Settings;

class PaymentController extends Controller
{
    private PaymentManagerService $paymentManagerService;

    public function __construct(PaymentManagerService $paymentManagerService)
    {
        $this->paymentManagerService = $paymentManagerService;
    }

    public function getCheckoutId()
    {
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a829418533cf31d01533d06f2ee06fa&amount=92.00&currency=USD&paymentType=DB";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA=='
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Establece esto en true en producción
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        return response()->json(json_decode($responseData, true));
    }

    public function getTransactionStatus($resourcePath)
    {
        // La URL base del ambiente de prueba o producción
        $url = "https://test.oppwa.com" . $resourcePath;
        $url .= "?entityId=8a829418533cf31d01533d06f2ee06fa"; // Incluye el entityId

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Establece esto en true en producción
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        curl_close($ch);

        // Decodifica y retorna la respuesta JSON
        return response()->json(json_decode($responseData, true));
    }

    public function index(PaymentGateway $paymentGateway, Order $order): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $credit          = false;
        $cashOnDelivery  = false;
        $paymentGateways = PaymentGateway::with('gatewayOptions')->where(['status' => Activity::ENABLE])->get();
        $company         = Settings::group('company')->all();
        $site            = Settings::group('site')->all();
        $logo            = ThemeSetting::where(['key' => 'theme_logo'])->first();
        $faviconLogo     = ThemeSetting::where(['key' => 'theme_favicon_logo'])->first();
        $currency        = Currency::findOrFail(Settings::group('site')->get('site_default_currency'));
        if ($order?->user?->balance >= $order->total) {
            $credit = true;
        }

        if ($site['site_cash_on_delivery'] == Activity::ENABLE) {
            $cashOnDelivery = true;
        }

        if (blank($order->transaction) && $order->payment_status === PaymentStatus::UNPAID) {
            return view('payment', [
                'company'         => $company,
                'logo'            => $logo,
                'currency'        => $currency,
                'faviconLogo'     => $faviconLogo,
                'paymentGateways' => $paymentGateways,
                'order'           => $order,
                'creditAmount'    => AppLibrary::currencyAmountFormat($order->user?->balance),
                'credit'          => $credit,
                'cashOnDelivery'  => $cashOnDelivery,
                'paymentMethod'   => $paymentGateway
            ]);
        }
        return redirect()->route('home')->with('error', trans('all.message.payment_canceled'));
    }

    public function payment(Order $order, PaymentRequest $request)
    {
        // Verifica si el método de pago es DataFast
        if ($request->paymentMethod === 'datafast') {
            // Implementa la lógica de pago para DataFast
            try {
                $data = [
                    'entity_id' => 'tu_entity_id', // Identificador de la entidad de DataFast.
                    'bearer_token' => 'tu_bearer_token', // Token de autenticación proporcionado por DataFast.
                    'MID' => 'tu_MID', // Identificador del comercio.
                    'TID' => 'tu_TID', // Identificador del terminal.

                    'amount' => $order->total, // Monto total del pedido.
                    'currency' => $order->currency, // Moneda del pedido (por ejemplo, USD, EUR).
                    'order_id' => $order->id, // Identificador único del pedido.

                    // Detalles de la tarjeta de crédito
                    'card_number' => $request->input('cardNumber'), // Número de tarjeta.
                    'expiry_date' => $request->input('expiryDate'), // Fecha de expiración (formato MMYY).
                    'cvv' => $request->input('cvv'), // Código de seguridad CVV.

                    // Información del titular de la tarjeta
                    'card_holder_name' => $request->input('cardHolderName'), // Nombre del titular de la tarjeta.
                    'card_holder_email' => $request->input('cardHolderEmail'), // Email del titular de la tarjeta.

                    // Información de facturación
                    'billing_address' => $request->input('billingAddress'), // Dirección de facturación.
                    'billing_city' => $request->input('billingCity'), // Ciudad de facturación.
                    'billing_state' => $request->input('billingState'), // Estado de facturación.
                    'billing_zip' => $request->input('billingZip'), // Código postal de facturación.
                    'billing_country' => $request->input('billingCountry'), // País de facturación.

                    // Opcionales según la implementación
                    'redirect_url' => route('payment.success', ['paymentGateway' => 'datafast', 'order' => $order]), // URL de redirección en caso de éxito.
                    'cancel_url' => route('payment.cancel', ['paymentGateway' => 'datafast', 'order' => $order]), // URL de redirección en caso de cancelación.
                    'fail_url' => route('payment.fail', ['paymentGateway' => 'datafast', 'order' => $order]), // URL de redirección en caso de fallo.

                    'description' => 'Pago por el pedido ' . $order->id, // Descripción del pago.
                    'ip_address' => $request->ip(), // IP del cliente.
                    'user_agent' => $request->header('User-Agent'), // User-Agent del navegador del cliente.

                    // Parámetros adicionales según los requerimientos de DataFast
                    'additional_data' => [
                        // Aquí podrías añadir cualquier otro dato adicional requerido por DataFast.
                    ],
                ];

                // Envía la solicitud a la API de DataFast
                $response = $this->sendToDataFast($data);

                // Maneja la respuesta de DataFast
                if ($response->isSuccessful()) {
                    // Actualiza el estado del pedido a pagado
                    $order->update(['payment_status' => PaymentStatus::PAID]);

                    // Redirige al usuario a la página de éxito
                    return redirect()->route('payment.success', [
                        'paymentGateway' => $request->paymentMethod,
                        'order' => $order
                    ]);
                } else {
                    // Redirige a la página de error con el mensaje de error de DataFast
                    return redirect()->route('payment.fail', [
                        'paymentGateway' => $request->paymentMethod,
                        'order' => $order
                    ])->with('error', $response->getMessage());
                }
            } catch (\Exception $e) {
                // Maneja excepciones y redirige con un mensaje de error
                return redirect()->route('payment.fail', [
                    'paymentGateway' => $request->paymentMethod,
                    'order' => $order
                ])->with('error', 'Error al procesar el pago: ' . $e->getMessage());
            }
        }

        // Mantiene la lógica existente para otros métodos de pago
        if ($this->paymentManagerService->gateway($request->paymentMethod)->status()) {
            $className = 'App\\Http\\PaymentGateways\\PaymentRequests\\' . ucfirst($request->paymentMethod);
            $gateway   = new $className;
            $request->validate($gateway->rules());
            return $this->paymentManagerService->gateway($request->paymentMethod)->payment($order, $request);
        } else {
            return redirect()->route('payment.index', ['paymentGateway' => $request->paymentMethod, 'order' => $order])->with(
                'error',
                trans('all.message.payment_gateway_disable')
            );
        }
    }

    // Método para enviar datos a la API de DataFast
    private function sendToDataFast($data)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.datafast.com/payment', [
            'form_params' => $data
        ]);

        return json_decode($response->getBody());
    }

    public function success(PaymentGateway $paymentGateway, Order $order, Request $request)
    {
        return $this->paymentManagerService->gateway($paymentGateway->slug)->success($order, $request);
    }

    public function fail(PaymentGateway $paymentGateway, Order $order, Request $request)
    {
        return $this->paymentManagerService->gateway($paymentGateway->slug)->fail($order, $request);
    }

    public function cancel(PaymentGateway $paymentGateway, Order $order, Request $request)
    {
        return $this->paymentManagerService->gateway($paymentGateway->slug)->cancel($order, $request);
    }

    public function successful(Order $order): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            SendOrderMail::dispatch(['order_id' => $order->id, 'status' => OrderStatus::PENDING]);
            SendOrderSms::dispatch(['order_id' => $order->id, 'status' => OrderStatus::PENDING]);
            SendOrderPush::dispatch(['order_id' => $order->id, 'status' => OrderStatus::PENDING]);

            SendOrderGotMail::dispatch(['order_id' => $order->id]);
            SendOrderGotSms::dispatch(['order_id' => $order->id]);
            SendOrderGotPush::dispatch(['order_id' => $order->id]);
        } catch (\Exception $e) {
        }

        return redirect('/#/account/order-details/' . $order->id . '?status=success');
    }
}
