<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\BlockPayment;
use App\Http\Middleware\isEmployer;
use App\Mail\PurchaseMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    const WEEKLY_AMOUNT = 50;
    const MONTHLY_AMOUNT = 185;
    const YEARLY_AMOUNT = 1300;
    const CURRENCY = 'USD';

    public function __construct()
    {
        $this->middleware(['auth', isEmployer::class, BlockPayment::class]);
    }

    public function subscribe()
    {
        return view('subscription.index');
    }

    public function startPayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'weekly',
                'description' => 'weekly subscription',
                'amount' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1
            ],
            'monthly' => [
                'name' => 'monthly',
                'description' => 'monthly subscription',
                'amount' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1
            ],
            'yearly' => [
                'name' => 'yearly',
                'description' => 'yearly subscription',
                'amount' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1
            ],
        ];

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $plan = null;
            if ($request->is('pay/weekly')) {
                $plan = $plans['weekly'];
                $billing = now()->addWeek()->startOfDay()->toDateString();
            } elseif ($request->is('pay/monthly')) {
                $plan = $plans['monthly'];
                $billing = now()->addMonth()->startOfDay()->toDateString();
            } elseif ($request->is('pay/yearly')) {
                $plan = $plans['yearly'];
                $billing = now()->addYear()->startOfDay()->toDateString();
            }
            if ($plan) {
                $successURL = URL::signedRoute('pay.success', [
                    'plan' => $plan['name'],
                    'billing' => $billing,
                ]);
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'mode' => 'payment',
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $plan['currency'],
                                'unit_amount' => $plan['amount'] * 100,
                                'product_data' => [
                                    'name' => $plan['name'],
                                    'description' => $plan['description'],
                                ],
                            ],
                            'quantity' => $plan['quantity']
                        ]],
                    'success_url' => $successURL,
                    'cancel_url' => route('pay.cancel'),
                ]);
                return redirect($session->url);
            }

        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billing = $request->billing;
        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'bill_end' => $billing,
            'status' => 'Paid'
        ]);
        try {
            Mail::to(auth()->user())->queue(new PurchaseMail($plan, $billing));
        } catch (\Exception $e) {
            return response()->json($e);
        }


        return redirect()->route('dashboard')->with('success', 'Payment was processed successfully');
    }

    public function paymentCancel()
    {
        return redirect()->route('dashboard')->with('error', 'Payment was unsuccessful');
    }
}
