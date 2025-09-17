'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';
const RESOURCES = {
  "assets/AssetManifest.json": "d31e76eb52c249cd7e99122c2bb2f87b",
"assets/assets/images/app_icon.png": "33680f9567d2b7c380aea582c6b245fe",
"assets/assets/images/app_logo.png": "71a4e03c629de0baa0302a82760fd18d",
"assets/FontManifest.json": "3ba95e877e8d977ed295b7a8efefeff7",
"assets/fonts/MaterialIcons-Regular.otf": "4e6447691c9509f7acdbf8a931a85ca1",
"assets/NOTICES": "20e3fc65fde7932fb98d53eba357b925",
"assets/packages/auth_buttons/images/default/apple.png": "ebc6d25b2a5f85ac1c55fc8493a6933d",
"assets/packages/auth_buttons/images/default/apple_white.png": "fee7941657354ff5a6522fb270de6b50",
"assets/packages/auth_buttons/images/default/email.png": "220771d987f09a46b5ee470d7d1fe14f",
"assets/packages/auth_buttons/images/default/email_white.png": "b138a1aedb7f7f0891923b0121cc8520",
"assets/packages/auth_buttons/images/default/facebook.png": "7cf5256d509b37c5e023d0e3bf89ca33",
"assets/packages/auth_buttons/images/default/facebook_white.png": "9377466f32681729736ca9347a2e4363",
"assets/packages/auth_buttons/images/default/github_black.png": "d7670a9b94f89048f0aa78dd1f813bc1",
"assets/packages/auth_buttons/images/default/github_white.png": "b69ee90f95f5baea1f6440b27d4d3d7f",
"assets/packages/auth_buttons/images/default/google.png": "6937ba6a7d2de8aa07701225859ae402",
"assets/packages/auth_buttons/images/default/huawei.png": "0ca2ffbecc245b5793e865ed98087fa8",
"assets/packages/auth_buttons/images/default/huawei_white.png": "b5c5ab42a71d5dde71d8cd965db05009",
"assets/packages/auth_buttons/images/default/microsoft.png": "96da9d69ca3c3f18e9383d01075a4a39",
"assets/packages/auth_buttons/images/default/twitter.png": "ce08a5ef8628e44e8f042f47d5df1661",
"assets/packages/auth_buttons/images/default/twitter_white.png": "0d4470494f8f7ed308ed1c0f59f13fa6",
"assets/packages/auth_buttons/images/outlined/apple.png": "982c4374fd8d68c835f51e1b218946c9",
"assets/packages/auth_buttons/images/outlined/apple_white.png": "b53bfa858ef99ed1cdcba417f5911847",
"assets/packages/auth_buttons/images/outlined/email.png": "4e322dbd031e5940d60ba4f82204d73d",
"assets/packages/auth_buttons/images/outlined/email_white.png": "3eed4eeffc6338fb1db70926f75e5dda",
"assets/packages/auth_buttons/images/outlined/facebook.png": "1ff2150aebd4781a3e290a1cc7dc1e1c",
"assets/packages/auth_buttons/images/outlined/facebook_white.png": "1148a3359d95ba55000798b3565d35ad",
"assets/packages/auth_buttons/images/outlined/google.png": "f16a82299f7fb65ad5b9fa493b4fdc79",
"assets/packages/auth_buttons/images/outlined/huawei.png": "596b8fc29dca10fb847162d8190ab922",
"assets/packages/auth_buttons/images/outlined/huawei_white.png": "fba6b79ab27cb950b8dc65d70a350cfa",
"assets/packages/auth_buttons/images/outlined/microsoft.png": "b74a53bdc17df88dd0ee39f302f8fb5a",
"assets/packages/auth_buttons/images/outlined/twitter.png": "6cc42f4430ea2d28e6bcebe8caba835e",
"assets/packages/auth_buttons/images/outlined/twitter_white.png": "7e0f8d607a2fd2e431d48bdad71cb7f9",
"assets/packages/auth_buttons/images/secondary/apple.png": "c92e950ff74f3d0aed25eae8f2b625a3",
"assets/packages/auth_buttons/images/secondary/email.png": "5a8046651666ff2e14ebb87473d87177",
"assets/packages/auth_buttons/images/secondary/email_white.png": "5f57417e36ae055d6f9f525e04c51213",
"assets/packages/auth_buttons/images/secondary/facebook.png": "17bc7ce24f8be2338c0fe756bc91021a",
"assets/packages/auth_buttons/images/secondary/google.png": "f6e6e8105bf24721e61dd67a38d894ed",
"assets/packages/auth_buttons/images/secondary/huawei.png": "2a9a4ae758b9ba527dc309de7f12706e",
"assets/packages/auth_buttons/images/secondary/microsoft.png": "8f8e4c2c6c1158fa0eb76c9dcca4a106",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "6d342eb68f170c97609e9da345464e5e",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_AMS-Regular.ttf": "657a5353a553777e270827bd1630e467",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Caligraphic-Bold.ttf": "a9c8e437146ef63fcd6fae7cf65ca859",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Caligraphic-Regular.ttf": "7ec92adfa4fe03eb8e9bfb60813df1fa",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Fraktur-Bold.ttf": "46b41c4de7a936d099575185a94855c4",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Fraktur-Regular.ttf": "dede6f2c7dad4402fa205644391b3a94",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Main-Bold.ttf": "9eef86c1f9efa78ab93d41a0551948f7",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Main-BoldItalic.ttf": "e3c361ea8d1c215805439ce0941a1c8d",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Main-Italic.ttf": "ac3b1882325add4f148f05db8cafd401",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Main-Regular.ttf": "5a5766c715ee765aa1398997643f1589",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Math-BoldItalic.ttf": "946a26954ab7fbd7ea78df07795a6cbc",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Math-Italic.ttf": "a7732ecb5840a15be39e1eda377bc21d",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_SansSerif-Bold.ttf": "ad0a28f28f736cf4c121bcb0e719b88a",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_SansSerif-Italic.ttf": "d89b80e7bdd57d238eeaa80ed9a1013a",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_SansSerif-Regular.ttf": "b5f967ed9e4933f1c3165a12fe3436df",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Script-Regular.ttf": "55d2dcd4778875a53ff09320a85a5296",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Size1-Regular.ttf": "1e6a3368d660edc3a2fbbe72edfeaa85",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Size2-Regular.ttf": "959972785387fe35f7d47dbfb0385bc4",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Size3-Regular.ttf": "e87212c26bb86c21eb028aba2ac53ec3",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Size4-Regular.ttf": "85554307b465da7eb785fd3ce52ad282",
"assets/packages/flutter_math_fork/lib/katex_fonts/fonts/KaTeX_Typewriter-Regular.ttf": "87f56927f1ba726ce0591955c8b3b42d",
"assets/packages/font_awesome_flutter/lib/fonts/fa-brands-400.ttf": "b37ae0f14cbc958316fac4635383b6e8",
"assets/packages/font_awesome_flutter/lib/fonts/fa-regular-400.ttf": "5178af1d278432bec8fc830d50996d6f",
"assets/packages/font_awesome_flutter/lib/fonts/fa-solid-900.ttf": "aa1ec80f1b30a51d64c72f669c1326a7",
"assets/packages/sigebase/assets/images/default_profile_image.png": "89df9c9d7079a465868034b6483ac977",
"assets/packages/sigebase/assets/images/sige_splash.png": "a36d87b97dab3880171501328371590c",
"assets/packages/sigegas/assets/images/app_icon.png": "32f1f679da7a0764e5139ef6bcd7e819",
"assets/packages/sigegas/assets/images/app_logo.png": "2977b2f8f9e7b65eb775c65674fed793",
"assets/packages/wakelock_web/assets/no_sleep.js": "7748a45cd593f33280669b29c2c8919a",
"icons/app_icon.png": "33680f9567d2b7c380aea582c6b245fe",
"index.html": "0ac801cdc57e5dd21a0688424dc72ee9",
"/": "0ac801cdc57e5dd21a0688424dc72ee9",
"main.dart.js": "a09dcd58c49b791efe2449cc891e0cce",
"manifest.json": "80cde1503e90c6dc98a5a0e196ab4b5a",
"version.json": "53937e66d74e8cef4a5f4544a97ef022"
};

// The application shell files that are downloaded before a service worker can
// start.
const CORE = [
  "/",
"main.dart.js",
"index.html",
"assets/NOTICES",
"assets/AssetManifest.json",
"assets/FontManifest.json"];
// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});

// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});

// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache.
        return response || fetch(event.request).then((response) => {
          cache.put(event.request, response.clone());
          return response;
        });
      })
    })
  );
});

self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});

// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}

// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
