/**
 * Register sw.js
 */
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.min.js', {scope: './'});
}
