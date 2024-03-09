<?php

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
      $cacheCreatedTimestamp = (int)$cacheCreated;
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

   if (!empty($releaseData) && !isset($releaseData['message'])) {
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
            if (str_contains($asset['name'], 'wordpress')) {
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

         // Optionally, immediately start the update process
         // Note: Automatic update without user action can be risky
         /*
         require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
         $upgrader = new Plugin_Upgrader();
         $upgrader->upgrade("$wpPluginSlug/$wpPluginSlug.php");
         */
      }
   }

   return $transient;
}
add_filter('site_transient_update_plugins', 'checkUpdatesFromGithub');
