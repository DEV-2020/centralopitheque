const path = require('path');

module.exports = {
  configureWebpack: {
    resolve: {
      alias: {
        Components: path.resolve(__dirname, 'src/components'),
      },
    },
  },

  css: {
    loaderOptions: {
      sass: {
        data: `
          @import "@/assets/scss/_variables.scss";
          @import "@/assets/scss/_fonts.scss";
          @import "@/assets/scss/_common.scss";
        `,
      },
    },
  },

  devServer: {
    public: process.env.SERVER_URL,
    port: 8080,
    disableHostCheck: true,
  },

  pluginOptions: {
    i18n: {
      locale: 'fr',
      fallbackLocale: 'en',
      localeDir: 'locales',
      enableInSFC: false,
    },
  },
};
