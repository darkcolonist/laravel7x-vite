<?php

namespace App\Http\Helpers;

class Vite
{
  static function resources($entryPointJS)
  {
    $viteURL = env("VITE_URL", "http://localhost:5173");
    $js = [
      /**
       * this element is required
       */
      $entryPointJS
    ];
    $css = [
      /**
       * add your css files here (optional)
       */
      "resources/js/app.css"
    ];

    $return = "";

    if (env("APP_ENV") === "local" && self::checkIfAlive("{$viteURL}/{$js[0]}", 2)) {
      /**
       * dev/local mode
       */
      $return = "<script type=\"module\" src=\"{$viteURL}/@vite/client\"></script>";

      foreach ($js as $jskey => $jsval) {
        $return .= "</script><script type=\"module\" src=\"{$viteURL}/{$jsval}\"></script>";
      }
    } else {
      /**
       * prod mode
       */
      $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);

      foreach ($js as $jskey => $jsval) {
        $return .= "<script type=\"module\" src=\"" . env("APP_URL") . "/build/" . $manifest[$jsval]['file'] . "\"></script>";
      }

      foreach ($css as $csskey => $cssval) {
        // dd($manifest[$cssval]["file"]);
        $return .= "<link rel=\"stylesheet\" href=\"" . env("APP_URL") . "/build/" . $manifest[$cssval]['file'] . "\" />";
      }
    }

    return $return;
  }

  private static function checkIfAlive($url, $timeout = 10)
  {
    $ch = curl_init($url);

    // Set request options
    curl_setopt_array($ch, array(
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_NOBODY => true,
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_USERAGENT => "page-check/1.0"
    ));

    // Execute request
    curl_exec($ch);

    // Check if an error occurred
    if (curl_errno($ch)) {
      curl_close($ch);
      return false;
    }

    // Get HTTP response code
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // dd([
    //   "url" => $url,
    //   "code" => $code,
    // ]);

    // Page is alive if 200 OK is received
    return $code === 200;
  }
}
