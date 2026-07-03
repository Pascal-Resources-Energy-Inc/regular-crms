<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Stove;
use App\TransactionDetail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Client::with(['serial', 'transactions'])->latest()->get();
        $stoves = Stove::whereNull('client_id')->orderBy('serial_number')->get();

        return view('customers', [
            'customers' => $customers,
            'stoves' => $stoves,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'serial_number' => 'required|exists:stoves,id',
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|digits:11',
            'facebook' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // $stove = Stove::where('id', $validated['serial_number'])
                //     ->whereNull('client_id')
                //     ->lockForUpdate()
                //     ->first();

                // if (!$stove) {
                //     throw new \RuntimeException('Selected serial number is already assigned to another customer.');
                // }

                $user = new User();
                $user->name = $validated['name'];
                $user->email = $validated['email_address'];
                $user->password = Hash::make('12345678');
                $user->role = 'Client';
                $user->status = 'active';
                $user->email_verified_at = now();
                $user->save();

                $client = new Client();
                $client->user_id = $user->id;
                $client->name = $validated['name'];
                $client->email_address = $validated['email_address'];
                $client->number = $validated['phone_number'];
                $client->facebook = $validated['facebook'];
                $client->address = $validated['address'];
                // $client->serial_number = $stove->id;
                $client->status = $validated['status'] ?? 'Active';
                $client->dealer_id = auth()->user()->id;
                $client->save();

                if (empty($client->client_reference)) {
                    $client->client_reference = 'CL-' . now()->format('Y') . '-' . str_pad($client->id, 5, '0', STR_PAD_LEFT);
                    $client->save();
                }

                // $stove->client_id = $client->id;
                // $stove->remarks = null;
                // $stove->save();
            });

            Alert::success('Customer Added', 'Customer account was created successfully.');
            return redirect()->route('dealer.customers');
        } catch (\Throwable $e) {
            Log::error('Customer creation failed: ' . $e->getMessage());

            Alert::error('Unable to Add Customer', $e->getMessage());
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $customer = Client::with('serial')->findOrFail($id);
        $transactions = TransactionDetail::where('client_id', $customer->id)
            ->orderByDesc('id')
            ->get();

        return view('customer', [
            'customer' => $customer,
            'transactions' => $transactions,
        ]);
    }

    public function getUser($id)
    {
        try {
            $scanned = trim($id);

            if (!$scanned) {
                return response()->json(['success' => false, 'message' => 'Invalid QR code data'], 400);
            }

            $stove = Stove::where('serial_number', 'like', "%{$scanned}%")->first();
            if (!$stove) {
                return response()->json(['success' => false, 'message' => 'No stove found'], 404);
            }

            $client = Client::find($stove->client_id);
            if (!$client) {
                return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
            }

            $user = User::find($client->user_id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User account not found'], 404);
            }

            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $client->id,
                    'customer_id' => $client->id,
                    'name' => $user->name,
                    'full_name' => $user->name,
                    'email' => $user->email ?? $client->email_address ?? 'N/A',
                    'address' => $client->address ?? 'N/A',
                    'number' => $client->number ?? 'N/A',
                    'phone' => $client->number ?? 'N/A',
                    'serial_number' => $stove->serial_number,
                    'avatar' => $client->avatar ?? null,
                ]
            ]);

        } catch (\Throwable $e) {
            Log::error('QR Scanner Error: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while processing'], 500);
        }
    }
}
