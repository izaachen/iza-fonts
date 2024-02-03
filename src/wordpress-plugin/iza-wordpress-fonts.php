<?php
/*
Plugin Name: IZA WordPress Fonts
Plugin URI: {{ package.homepage }}
Description: {{ package.description }}
Version: {{ package.version }}
Author: {{ package.author }}
*/

function iza_enqueue_styles() {
   wp_enqueue_style('iza-font-face', plugin_dir_url(__FILE__) . 'wp-font-face.css');
}

add_action('wp_enqueue_scripts', 'iza_enqueue_styles', 9999);

/**
 * Retrieve updates from GitHub
 */
function checkUpdatesFromGithub($transient) {
   // Config
   $wpPluginSlug = 'iza-wordpress-fonts';
   $githubRepoSlug = 'izaachen/iza-fonts';
   $githubRepoUrl = "https://github.com/$githubRepoSlug";
   $githubReleasesUrl = "https://api.github.com/repos/$githubRepoSlug/releases";

   $cacheFilename = 'github-releases.json';
   $cacheCreatedFilename = 'github-checked-at.txt';

   if (empty($transient->checked)) {
      return $transient;
   }

   // Check if the cache file exists
   $cacheFile = plugin_dir_path(__FILE__) . $cacheFilename;
   $cacheCreatedFile = plugin_dir_path(__FILE__) . $cacheCreatedFilename;

   // Check if cache is older than 1 hour
   $isCacheOld = false;
   if (file_exists($cacheCreatedFile)) {
      $cacheCreated = file_get_contents($cacheCreatedFile);
      $cacheCreatedTimestamp = intval($cacheCreated);
      $currentTimestamp = time();
      $diff = $currentTimestamp - $cacheCreatedTimestamp;
      if ($diff > 3600) {
         $isCacheOld = true;
      }
   }

   if (file_exists($cacheFile) && !$isCacheOld) {
      $releaseData = json_decode(file_get_contents($cacheFile), true);
   } else {
      // Fetch the release data from GitHub
      $response = wp_remote_get($githubReleasesUrl, [
         'timeout' => 10,
         'headers' => [
            'Accept' => 'application/vnd.github.v3+json',
         ],
      ]);
      if (is_wp_error($response)) {
         return $transient;
      }
      $releaseData = json_decode(wp_remote_retrieve_body($response), true);
   }

   if (!empty($releaseData) && !$releaseData['message']) {
      // Cache the response in a file
      $time = time();
      $cacheFile = plugin_dir_path(__FILE__) . $cacheFilename;
      file_put_contents($cacheFile, json_encode($releaseData));
      $cacheCreatedFile = plugin_dir_path(__FILE__) . $cacheCreatedFilename;
      file_put_contents($cacheCreatedFile, $time);

      $currentVersion = $transient->checked["$wpPluginSlug/$wpPluginSlug.php"];
      $latestVersion = ltrim($releaseData[0]['tag_name'], 'v');

      if (version_compare($currentVersion, $latestVersion, '<')) {
         // Find asset, which name contains 'wordpress'
         foreach ($releaseData[0]['assets'] as $key => $asset) {
            if (strpos($asset['name'], 'wordpress') !== false) {
               $wpAssetKey = $key;
               break;
            }
         }

         if ($wpAssetKey === false) {
            return $transient;
         }

         $wpAsset = $releaseData[0]['assets'][$wpAssetKey];
         $transient->response["$wpPluginSlug/$wpPluginSlug.php"] = (object) [
            'slug' => $wpPluginSlug,
            'new_version' => $latestVersion,
            'package' => $wpAsset['browser_download_url'],
            'url' => $githubRepoUrl,
         ];
      }
   }

   return $transient;
}
add_filter('site_transient_update_plugins', 'checkUpdatesFromGithub');
