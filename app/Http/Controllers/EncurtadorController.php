<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncurtarRequest;
use App\Models\Url;
use App\Services\EncurtadorService;
use Exception;

class EncurtadorController extends Controller
{
    public function index(string|null $hash = null)
    {
        $url = Url::where("hash", $hash)->first();

        if ($hash && isset($url->destiny)) {
            $url = Url::where("hash", $hash)->first();

            return redirect($url->origin);
        }

        return redirect()->route('generate');
    }

    public function encurtar(EncurtarRequest $request)
    {
        $data = $request->validated();

        try {
            $encurtador = new EncurtadorService($data['url']);

            $encurtador->handle();

            $destiny = $encurtador->getDestiny();

            $hash = $encurtador->getHash();

            $urlSave = Url::updateOrCreate([
                "origin" => $data["url"],
            ], [
                "destiny" => $destiny,
                "hash"    => $hash,
            ]);

            return back()
                ->with("success", "Url cadastrada com sucesso!")
                ->with("destiny", $urlSave->destiny);

        } catch (Exception $exception) {
            return back()
                ->with("error", $exception->getMessage());

        }
    }
}
