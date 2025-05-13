<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackedProduct;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Carbon\Carbon;

class AmazonPriceController extends Controller
{
   public function check(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');

        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ],
            ]);

            $html = $response->getContent();
            $crawler = new Crawler($html);

            $title = $crawler->filter('#productTitle')->text('', false);
            $priceText = $crawler->filter('#priceblock_ourprice, #priceblock_dealprice, .a-price .a-offscreen')->text('', false);
            $price = floatval(preg_replace('/[^\d.]/', '', $priceText));

            // Find or create the product record
            $product = TrackedProduct::firstOrNew(['url' => $url]);

            $priceDrop = false;

            if ($product->last_price !== null && $price < $product->last_price) {
                $priceDrop = true;
            }

            $product->title = trim($title);
            $product->last_price = $price;
            $product->last_checked_at = Carbon::now();
            $product->save();

            return response()->json([
                'title' => $product->title,
                'current_price' => $price,
                'last_checked_at' => $product->last_checked_at,
                'price_drop' => $priceDrop,
                'message' => $priceDrop ? '✅ Price dropped!' : 'ℹ️ Price remains the same.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch product data. ' . $e->getMessage(),
            ], 400);
        }
    }
}
