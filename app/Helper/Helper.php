<?php

namespace App\Helper;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Question;
use Session;
use App\Models\Setting;
use App\Models\Sitemap;

class Helper
{

    public static function successMsg($type, $msg)
    {
        if ($type == 'insert') {
            session()->flash('message', $msg . ' Inserted Successfully.');
        } else if ($type == 'update') {
            session()->flash('message', $msg . ' Updated Successfully.');
        } else if ($type == 'delete') {
            session()->flash('message', $msg . ' Deleted Successfully.');
        } else if ($type == 'active') {
            session()->flash('message', $msg . ' Active Successfully.');
        } else if ($type == 'inactive') {
            session()->flash('message', $msg . ' Deactive Successfully.');
        } else if ($type == 'custom') {
            session()->flash('message', $msg);
        }
    }
    public static function settings()
    {
        return Setting::with(['default_customer'])->where('id', 1)->first();
    }
    public static function dashboard_count_data()
    {
        $category_count = Category::count();
        $product_count = Product::count();
        $customer_count = Customer::count();
        $invoice_count = Invoice::count();
        return [
            'category_count' => $category_count,
            'product_count' => $product_count,
            'customer_count' => $customer_count,
            'invoice_count' => $invoice_count
        ];
    }

    public static function searchAnswer($questionId)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL => "https://api.stackexchange.com/2.2/questions/" . $questionId . "/answers?pagesize=20&order=desc&sort=votes&site=stackoverflow&filter=!-.AG)rX2RGrL&key=78rjZg2x1Zo7pSqooZLrcg((",
            CURLOPT_URL => "http://www.viewtutorial.tk/answer.php?questionId=" . $questionId . "&extra=extra",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 5c1da6f1-c302-62c2-86e8-e138fba55696"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public static function createSitemap($checkCount, $sitemapLimit)
    {
        if ($checkCount >= $sitemapLimit) {

            $dom = new \DOMDocument();
            $dom->formatOutput = true;
            $dom->encoding = "UTF-8";

            if (!is_dir('public/sitemap')) {
                mkdir('public/sitemap', 0777, true);
            }
            $fileName = 'public/sitemap/sitemap-' . time() . '.xml';

            $urlset = $dom->createElement('urlset');
            $dom->appendChild($urlset);

            $urlsetAttr = new \DOMAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $urlset->setAttributeNode($urlsetAttr);

            $questions = Question::where('sitemap', 0)
                ->where('answer_status', 1)
                ->limit($sitemapLimit)->get();
            foreach ($questions as $q) {
                $url = $dom->createElement('url');
                $urlset->appendChild($url);

                $loc = $dom->createElement('loc', $q->slug);
                $url->appendChild($loc);

                $lastmod = $dom->createElement('lastmod', date('Y-m-d'));
                $url->appendChild($lastmod);

                Question::find($q->id)->update(['sitemap' => 1]);
            }

            $dom->save($fileName);

            Sitemap::create(['filename' => $fileName]);
        }
    }
}
