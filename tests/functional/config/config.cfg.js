export default {
  // www_base_host: 'http://localhost/~admin/wordpress_4.8.2/wp-admin/',
  www_base_host: process.env.DEPLOY_HOST,
  speed: { speed: 0.7 },
  isVisible: {
    visibilityCheck: true,
    timeout: 30000
  },
  resolution: {
    desktopResolution: {
      width: 1280,
      height: 600
    },
    mobileResolution: {
      width: 400,
      height: 600
    }
  }
};

