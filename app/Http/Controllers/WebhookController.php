<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebhookData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function receive(Request $request)
    {
        // Validate and store the incoming data
        $data = $request->all();
        
        // Store data in the database
        $webhookData = WebhookData::create([
            'timestamp' => $data['timestamp'],
            'token' => $data['token'],
            'signature' => $data['signature'],
            'mover_id' => $data['MoverId'],
            'name' => $data['Name'],
            'email' => $data['Email'],
            'telephone' => $data['Telephone'],
            'estimated_move_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $data['EstimatedMoveDate']),
            'charge' => $data['Charge'],
            'charge_status' => $data['ChargeStatus'],
            'rank' => $data['Rank'],
            'comments' => $data['Comments'],
            'transaction' => $data['Transaction'],
            'quote_discount' => $data['Quote_Discount'],
            'quote_vat' => $data['Quote_VAT'],
            'quote_total' => $data['Quote_Total'],
            'sale_post_district' => $data['Sale_PostDistrict'],
            'sale_address' => $data['Sale_Address'],
            'sale_value' => $data['Sale_Value'],
            'sale_type' => $data['Sale_Type'],
            'sale_is_shared_ownership' => filter_var($data['Sale_IsSharedOwnership'], FILTER_VALIDATE_BOOLEAN),
            'sale_has_mortgage' => filter_var($data['Sale_HasMortgage'], FILTER_VALIDATE_BOOLEAN),
            'sale_is_flat' => isset($data['Sale_IsFlat']) ? filter_var($data['Sale_IsFlat'], FILTER_VALIDATE_BOOLEAN) : null,
            'sale_is_help_to_buy_shared_ownership' => isset($data['Sale_IsHelpToBuySharedOwnership']) ? filter_var($data['Sale_IsHelpToBuySharedOwnership'], FILTER_VALIDATE_BOOLEAN) : null,
            'quote_sale_fees' => $data['Quote_Sale_Fees'],
            'quote_sale_fees_breakdown' => json_encode($data['Quote_Sale_Fees_Breakdown']),
            'quote_sale_disbursements' => $data['Quote_Sale_Disbursements'],
            'quote_sale_disbursements_breakdown' => json_encode($data['Quote_Sale_Disbursements_Breakdown']),
            'quote_sale_total' => $data['Quote_Sale_Total'],
            'headers' => json_encode($data['headers']),
        ]);

        // Store data in a file
        $fileName = 'webhook_data_' . now()->timestamp . '.json';
        Storage::put('webhook_data/' . $fileName, json_encode($data));

        return response()->json(['status' => 'success'], 200);
    }

    public function send(Request $request)
    {
        // Get the data to send
        $webhookData = WebhookData::latest()->first();

        if ($webhookData) {
            $data = $webhookData->toArray();

            // Send data to another URL
            $response = Http::post('https://other-webhook-url.com', $data);

            return response()->json(['status' => 'success', 'response' => $response->json()], 200);
        }

        return response()->json(['status' => 'no data found'], 404);
    }
}
